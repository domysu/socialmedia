<template>
  <ckeditor :editor="editor" @input="onEditorChange" :config="editorConfig" />

</template>

<script setup>
import { ref, defineEmits } from 'vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import { ClassicEditor, AutoLink, Autosave, Bold, Essentials, Italic, Link, Paragraph } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';


const emit = defineEmits(["update:modelValue"]);

const editor = ClassicEditor;


function onEditorChange(event) {
  emit('update:modelValue', event)
}


const editorConfig = {

toolbar: {
  items: ['bold', 'italic', '|', 'link'],
  shouldNotGroupWhenFull: false,
},
plugins: [
  AutoLink, Autosave, Bold, Essentials, Italic, Link, Paragraph],

};
</script>
