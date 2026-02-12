<template>
  <div>
    <h3>{{ form.id ? "Edit Book" : "Add Book" }}</h3>

    <form @submit.prevent="submit">
      <input v-model="form.title" placeholder="Title" required />
      <input v-model="form.author" placeholder="Author" required />
      <input v-model="form.publisher" placeholder="Publisher" required />
      <input v-model="form.genre" placeholder="Genre" required />
      <input type="date" v-model="form.publication_date" required />
      <input type="number" v-model="form.words_count" placeholder="Words count" required />
      <input type="number" step="0.01" v-model="form.price" placeholder="Price" required />

      <button type="submit">
        {{ form.id ? "Update" : "Create" }}
      </button>

      <button v-if="form.id" type="button" @click="resetForm">
        Cancel
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, watch } from "vue";
import { createBook, updateBook } from "../api/books";

const props = defineProps({
  book: Object,
});

const emit = defineEmits(["saved"]);

const emptyForm = {
  id: null,
  title: "",
  author: "",
  publisher: "",
  genre: "",
  publication_date: "",
  words_count: "",
  price: "",
};

const form = reactive({ ...emptyForm });

// ✅ declare first
const resetForm = () => {
  Object.assign(form, emptyForm);
};

// ✅ then watch
watch(
  () => props.book,
  (newBook) => {
    if (newBook) {
      Object.assign(form, newBook);
    } else {
      resetForm();
    }
  },
  { immediate: true },
);

const submit = async () => {
  if (form.id) {
    await updateBook(form.id, form);
  } else {
    await createBook(form);
  }

  emit("saved");
  resetForm();
};
</script>
