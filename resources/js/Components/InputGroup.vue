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
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
  
      <span v-if="error" class="text-red-500 text-xs">{{ error }}</span>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    label: String,
    name: String,
    error: String,
    modelValue: [String, Number], // Acepta tanto String como Number
    options: {
      type: Array,
      required: true,
      // Se espera que las opciones sean un array de objetos con las claves 'label' y 'value'
    }
  });
  
  const emit = defineEmits(['update:modelValue']);
  
  const internalValue = ref(props.modelValue);
  
  watch(internalValue, (newValue) => {
    emit('update:modelValue', newValue);
  });
  </script>
  