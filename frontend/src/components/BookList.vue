<template>
  <div>
    <h2>Books</h2>

    <BookForm :book="editingBook" @saved="handleSaved" />

    <ul>
      <li v-for="book in books" :key="book.id">
        {{ book.title }} by {{ book.author }}

        <button @click="startEdit(book)">Edit</button>
        <button @click="removeBook(book.id)">Delete</button>
      </li>
    </ul>

    <div class="pagination">
      <button :disabled="meta.current_page <= 1" @click="changePage(meta.current_page - 1)">
        Previous
      </button>

      <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>

      <button :disabled="meta.current_page >= meta.last_page" @click="changePage(meta.current_page + 1)">
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { getBooks, deleteBook } from "../api/books";
import BookForm from "./BookForm.vue";

const books = ref([]);
const editingBook = ref(null);

const meta = ref({
  current_page: 1,
  last_page: 1,
});

const currentPage = ref(1);
const perPage = 10;

const fetchBooks = async (page = 1) => {
  const { data } = await getBooks({
    page,
    per_page: perPage,
  });

  books.value = data.data;
  meta.value = data.meta;
  currentPage.value = data.meta.current_page;
};

const changePage = (page) => {
  fetchBooks(page);
};

const startEdit = (book) => {
  editingBook.value = { ...book }; // shallow clone for safety
};

const handleSaved = () => {
  editingBook.value = null;
  fetchBooks(currentPage.value);
};

const removeBook = async (id) => {
  if (!confirm("Delete this book?")) return;

  await deleteBook(id);

  // If last item removed on last page
  if (books.value.length === 1 && currentPage.value > 1) {
    fetchBooks(currentPage.value - 1);
  } else {
    fetchBooks(currentPage.value);
  }
};

onMounted(() => fetchBooks());
</script>

<style scoped>
.pagination {
  margin-top: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.pagination button {
  padding: 6px 12px;
  cursor: pointer;
}

.pagination button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

ul li {
  margin-bottom: 8px;
  display: flex;
  gap: 8px;
  align-items: center;
}
</style>
