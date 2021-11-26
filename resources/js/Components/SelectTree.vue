<template>
  <div
      id="app"
      class="relative flex min-w-full"
    >
    <div class="relative min-w-full" >  
      <input 
        type="text"
        class="min-w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)"
        @focus="isOptionsExpanded = !isOptionsExpanded"
        @blur="isOptionsExpanded = false"
        ref="input" />

      <span
        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
      >
        <i v-if="modelValue" class="fas fa-times text-gray-400 z-20 hover:text-gray-500"></i>
        <i v-else @click="isOptionsExpanded = !isOptionsExpanded" class="fas fa-chevron-down text-gray-400 z-20 hover:text-gray-500"></i>
      </span>
    </div>
    <transition
      enter-active-class="transform transition duration-500 ease-custom"
      enter-class="-translate-y-1/2 scale-y-0 opacity-0"
      enter-to-class="translate-y-0 scale-y-100 opacity-100"
      leave-active-class="transform transition duration-300 ease-custom"
      leave-class="translate-y-0 scale-y-100 opacity-100"
      leave-to-class="-translate-y-1/2 scale-y-0 opacity-0"
    >
      <ul
        v-show="isOptionsExpanded"
        class="absolute min-w-full mt-12 left-0 right-0 mb-4 bg-white divide-y rounded-lg shadow-lg overflow-hidden"
      >
        <li
          v-for="(option, index) in options"
          :key="index"
          class="px-3 py-2 transition-colors duration-300 hover:bg-gray-200"
          @mousedown.prevent="setOption(option)"
        >
          {{ option.name }}
        </li>
        <li v-if="!options">
          data not found
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: [
          'modelValue',
          'options',
        ],

        data() {
          return {
            isOptionsExpanded: false,
            selectedOption: [],
          };
        },

        emits: ['update:modelValue'],

        methods: {
          focus() {
            this.$refs.input.focus()
          }
        }
    })
</script>
<style>
.ease-custom {
  transition-timing-function: cubic-bezier(.61,-0.53,.43,1.43);
}
</style>