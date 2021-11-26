<template>
  <div class="flex flex-col p-4 bg-white border border-gray-200 border-solid">
    <div
        id="app"
        class="relative flex min-w-full"
        v-show="Object.keys(selectedOption).length == 0"
      >
      <div class="relative min-w-full" >  
        <input 
          type="text"
          class="min-w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          @focus="isOptionsExpanded = !isOptionsExpanded"
          @blur="isOptionsExpanded = false"
          v-on:keyup="onSearchRooms($event.target.value)"
          ref="input" />

        <span
          class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
        >
          <i v-if="modelValue" class="fas fa-times text-gray-400 z-20 hover:text-gray-500"></i>
          <i class="fas fa-chevron-down text-gray-400 z-20 hover:text-gray-500"></i>
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
            class="px-3 py-2 transition-colors duration-300 hover:bg-gray-200 cursor-pointer"
            @click="handleClick(option)"
          >
            {{ option.name }} || NISN : {{ option.student.nisn }}
          </li>
          <li v-if="options.length == 0">
            data not found
          </li>
        </ul>
      </transition>
    </div>

    <div class="bg-blue-800 py-4 lg:px-4" v-show="Object.keys(selectedOption).length > 0">
      <div class="grid grid-cols-2 gap-4 mt-1 p-2 bg-blue-800 text-blue-100 " role="alert">
        <div class="font-extrabold text-2xl">{{selectedOption?.name}}</div>
        <div class="text-right"><span @click="clearClick()" class="cursor-pointer text-blue hover:text-blue-300">Batal</span></div>
        <div>NISN: {{selectedOption?.student?.nisn}}</div>
        <div>NIS: {{selectedOption?.student?.nis}}</div>
        <div>DESC: {{selectedOption?.student?.room?.description}}</div>
        <div>Telfon/HP: {{selectedOption?.student?.phone}}</div>
        <div>SPP: {{selectedOption?.student?.room?.priceRupiah}}</div>
        <div>Daftar Ulang: {{selectedOption?.student?.room?.reRegistrationRupiah}}</div>
        <div>{{selectedOption?.student?.address}}</div>
      </div>
    </div>
  </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
      props: {
        modelValue: {
          type: String,
          default: null
        },
        selected: {
          type: Object,
          default: {}
        },
      },

      data() {
        return {
          search: null,
          isOptionsExpanded: false,
          options: [],
          selectedOption: {},
        };
      },

      emits: ['update:modelValue', 'objectValue'],

      methods: {
        focus() {
          this.$refs.input.focus()
        },
        getRooms: function(searchVal) {
          this.options = []; 
          axios.get(route('json.users.index', {student: searchVal})).then(response => {
              this.options = response.data.data;
          });
        },
        onSearchRooms(searchVal) {
          if (this.timer) {
              clearTimeout(this.timer);
              this.timer = null;
          }
          this.timer = setTimeout(() => {
            this.getRooms(searchVal);
            this.isOptionsExpanded = true;
          }, 800);
        },
        handleClick(option) {
          this.selectedOption = option;
          this.$emit("objectValue", option);
        },
        clearClick(option, student) {
          this.selectedOption = {};
        }
      },
      beforeMount(){
        this.getRooms(this.search);
        this.isOptionsExpanded = false;
        this.selectedOption = this.selected
      }
    })
</script>
<style>
.ease-custom {
  transition-timing-function: cubic-bezier(.61,-0.53,.43,1.43);
}
</style>