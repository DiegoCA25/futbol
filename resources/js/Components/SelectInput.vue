<template>
    <div class="mb-4">
      <label :for="name" class="block text-sm font-medium text-gray-700">{{ label }}</label>
  
      <select
        v-bind="$attrs"
        v-model="internalValue"
        :id="name"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
      >
        <option disabled value="">Selecciona una opción</option>
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
      </select>
  
      <span v-if="error" class="text-red-500 text-xs">{{ error }}</span>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    label: String,
    name: String,
    options: Array, // Recibimos las opciones como un array
    error: String,
    modelValue: String,
  });
  
  const emit = defineEmits(['update:modelValue']);
  
  const internalValue = ref(props.modelValue);
  
  watch(internalValue, (newValue) => {
    emit('update:modelValue', newValue);
  });
  </script>
  