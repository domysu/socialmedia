<template>
  <div>
    <ckeditor
      :editor="editor"
      @input="onEditorChange"
      v-model="props.output"
      :config="editorConfig"
    />
  </div>
</template>

<script setup>
import { ref, defineEmits, defineProps } from "vue";
import { Ckeditor } from "@ckeditor/ckeditor5-vue";
import {
  ClassicEditor,
  AutoLink,
  Autosave,
  Bold,
  Essentials,
  Italic,
  Link,
  Paragraph,
} from "ckeditor5";
import "ckeditor5/ckeditor5.css";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({

    output: {
      type: Object,
      default: () => " ",
    },
    
})


const editor = ClassicEditor;

function onEditorChange(event) {
  emit("update:modelValue", event);
}

const editorConfig = {
  toolbar: {
    items: ["bold", "italic", "|", "link"],
    shouldNotGroupWhenFull: false,
    allowedContent: true,
  },
  plugins: [AutoLink, Autosave, Bold, Essentials, Italic, Link, Paragraph],
};
</script>
