<template>
  <div class="flex flex-col min-h-screen">
    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Product Page</h1>
    <div class="flex items-center space-x-4">
        <select v-model="selectedTitle" @change="updateform()" class="text-lg bg-gray-200 text-gray-800 border border-gray-400 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option>Select Title</option>
            <option v-for="value in titles" :key="value.id" :value="value.id">
                {{ value.title }}
            </option>
        </select>
        <button @click="moreInfo = !moreInfo" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Add Subtitle
        </button>
        
    </div>
</header>


    <main class="flex-grow p-8">
      <section class="bg-white shadow-md rounded-lg p-6">
        
        <div v-for="name in titles" :key="name.id">
          <h2 class="text-xl font-semibold mb-4">{{ name.title }}</h2>
          <div v-for="subtitle in name.subtitles" :key="subtitle.id">
            <h3 class="text-xl font-semibold mb-4">{{ subtitle.subtitle }}</h3>
            <p class="text-xl font-semibold mb-4">{{ subtitle.content }}</p>
            <img
              :src="`/storage/${subtitle.image}`"
              :alt="subtitle.name || 'Subtitle Image'"
              class="object-cover mx-auto rounded overflow-hidden w-auto h-24 max-w-36"
          />  
          </div>
          
        </div>
        
        <button @click="showMore" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
          Show More
        </button>
        <div v-if="moreInfo" class="mt-4">
          <p>
            Here is some additional information displayed after clicking the button.
          </p>
        </div>
      </section>

      
      <!-- Subtitle Form -->
    <div v-if="moreInfo" class="mt-4 bg-white rounded-lg shadow p-4">
      <h3 class="text-lg font-semibold mb-2">Add Subtitle</h3>
      <form @submit.prevent="submitSubtitle">
        <div class="mb-4">
          <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
          <select v-model="selectedTitle" @change="updateform()" class="text-lg bg-gray-200 text-gray-800 border border-gray-400 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option>Select Title</option>
            <option v-for="value in titles" :key="value.id" :value="value.id">
                {{ value.title }}
            </option>
        </select>
        
        </div>
        <div class="mb-4">
          <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900">Subtitle</label>
          <input type="text" v-model="formdata.subtitle" id="subtitle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Enter subtitle" >
          <div v-if="formdata.errors.subtitle">{{ formdata.errors.email }}</div>
        </div>
        <div class="mb-4">
          <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900">content</label>
          <input type="text" v-model="formdata.content" id="subtitle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Enter content" >
        </div>
        <div class="mb-4">
          <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900">image</label>
          <input type="file" @input="formdata.image = $event.target.files[0]" id="image" accept="image/*"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" >  
          </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
          Submit
        </button>
      </form>
    </div>
    </main>

    <footer class="bg-gray-800 text-white text-center p-4">
      <p>&copy; 2024 My Single Page App. All rights reserved.</p>
    </footer>
  </div>
</template>




<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps(['titles'])
const moreInfo = ref(false);
const formdata = useForm({
title_id: '',
subtitle: '',
content: '',
image: null
})

const errors = ref({})

function submitSubtitle() {
router.post('/store-subtitle', formdata, {
  onError: (error) => {
    console.error('Submission error', error);
  },
  onSuccess: () => {
    console.log('Success!');
  }
})

}
const selectedTitle = ref('')
const updateform = () => {
  formdata.title_id = selectedTitle.value
  formdata.subtitle = props.titles.find((title) => title.id === selectedTitle.value).subtitle
  formdata.content = props.titles.find((title) => title.id === selectedTitle.value).content 
}


</script>
<style scoped>
/* You can add additional styles here */
</style>
