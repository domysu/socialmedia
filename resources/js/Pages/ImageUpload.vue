<template>
    <div class="upload-container">
      <h3>Upload Image</h3>
  
      <!-- Image Upload Form -->
      <form @submit.prevent="submitImage">
        <input type="file" ref="fileInput" @change="onFileChange" />
        <button type="submit">Upload</button>
      </form>
  
      <!-- Show response -->
      <div v-if="response">
        <p>File uploaded successfully!</p>
        <p>File path: <strong>{{ response.path }}</strong></p>
      </div>
  
      <!-- Show errors -->
      <div v-if="error">
        <p>Error: {{ error }}</p>
      </div>
    </div>
  </template>
  
  <script setup>
  // Composition API style with `<script setup>`
  import { ref } from 'vue';
  
  // Reactive variables for file, response, and error
  const file = ref(null);
  const response = ref(null);
  const error = ref(null);
  
  // Handle file selection
  const onFileChange = (event) => {
    file.value = event.target.files[0];
  };
  
  // Submit the image for upload
  const submitImage = async () => {
    if (!file.value) {
      error.value = "Please select an image.";
      return;
    }
  
    const formData = new FormData();
    formData.append('image', file.value);
  
    try {
      const res = await fetch('/test-upload', {
        method: 'POST',
        body: formData,
      });
  
      if (!res.ok) {
        throw new Error('File upload failed.');
      }
  
      const data = await res.json();
      response.value = data;
      error.value = null;
    } catch (err) {
      error.value = err.message;
      response.value = null;
    }
  };
  </script>
  
  <style scoped>
  .upload-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
  }
  
  button {
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #45a049;
  }
  
  input[type="file"] {
    margin-bottom: 10px;
  }
  </style>
  