import axios from 'axios';

const API_URL = 'http://localhost:8000/api/books';

export const getBooks = (params = {}) => axios.get(API_URL, { params });
export const getBook = (id) => axios.get(`${API_URL}/${id}`);
export const createBook = (data) => axios.post(API_URL, data);
export const updateBook = (id, data) => axios.patch(`${API_URL}/${id}`, data);
export const deleteBook = (id) => axios.delete(`${API_URL}/${id}`);
