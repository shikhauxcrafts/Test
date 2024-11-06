<template>
  <div class="bg-primary">
     <div class="image-container max-h-full	">
        <img src="/Banner-1.jpg" alt="Background Image" class="banner">
     </div>
     <div class="content">
        <h2>Discover Excellence in Every Sheet</h2>
        <p class="pt-3">Explore our top-quality Stationary, Copier Paper and thermal rolls</p>
     </div>
     <div>
        
        <div>
           <h2 class="text-4xl font-bold text-center py-12 font-mono tracking-wider	antialiased uppercase">Our <span class="text-cyan-900">Products</span></h2>
        </div>
        <div></div>
     </div>
     <div v-for="name in titles" :key="name.id" class="pb-5">
      <h1 class="heading ml-20 py-4 font-bold text-5xl	">{{ name.title }}</h1>

      <div v-for="(subtitle, index) in name.subtitles" :key="subtitle.id" class="grid grid-cols-3 grid-flow-row ml-20" >
        <div style="margin-left: 10px;" :class="{'order-last': index % 2 !== 0, 'col-span-1': true}">
          <img class="image w-full h-auto rounded-md" :src="`/storage/${subtitle.image}`" :alt="subtitle.name || 'Subtitle Image'">
        </div>
        <div :class="['col-span-2', 'max-h-px', 'mt-2.5' , 'ml-3', index % 2 === 0 ? 'pl-8' : 'pr-8']">
           <h3 class="title">{{ subtitle.subtitle }}</h3>
           <p class="space-y-5 font-thin productcontent">{{ subtitle.content }}</p>
        </div>
     </div>
     </div>
     


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
  /* Full page container for the layout */
.full-page {
  width: 100vw;      /* Full viewport width */
  height: 100vh;     /* Full viewport height */
  position: relative; /* Needed for absolute positioning of .content */
  background-color: #f0f0f0; /* Optional: to add background color */
}

/* Styling for the content section */
.productcontent {
  font-size: 3vh;
  letter-spacing: normal;
  font-family: inherit;
}

.title {
  font-size: 4vh;
  font-family: calibri, sans-serif;
  margin-top: 20px;
  margin-bottom: 5px;
}

.image {
  height: 230px;
  max-width: 350px;  /* Make the image responsive */
  border-radius: 8px;
}

.heading {
  font-size: 30px;
  font-weight: bold;
  margin-top: 10px;
  margin-bottom: 20px;
  
}

/* The container for the background image */
.image-container {
  position: relative;
  width: 100%;
  height: 60vh;  /* Takes up 60% of the viewport height */
}

/* Banner image styling */
.banner {
  width: 100%;        /* Make the image fill the container */
  height: 100%;       /* Ensure it takes up full container height */
  object-fit: cover;  /* Makes sure the image covers the area without stretching */
}

/* Center content over the image */
.content {
  position: absolute;
  top: 30%;            /* Positioning the content at 30% of the container height */
  left: 50%;           /* Center horizontally */
  transform: translate(-50%, -50%); /* Center the content */
  text-align: center;
  color: white;        /* Change text color */
  padding: 10px;
}

.content h2 {
  margin: 0;
  font-size: 3rem;      /* Adjust font size for the heading */
  font-weight: bold;
  white-space: nowrap; /* Prevents the text from wrapping to a new line */
  overflow: hidden;    /* Optional: hides any overflow if the text exceeds its container */
  text-overflow: ellipsis; 
}

.content p {
  margin-top: 10px;
  font-size: 2rem; 
    /* Adjust font size for the paragraph */
}

  </style>