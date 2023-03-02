<template>
  <Head title="Home" />

  <TwitterLayout>
    <div class="text-white">
      <div class="flex" v-for="tweet in tweets" :key="tweet">
        <Tweet :tweet="tweet" />
      </div>
      <div class="border-b border-gray-800 mt-2"></div>
    </div>
  </TwitterLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import TwitterLayout from "@/Layouts/TwitterLayout.vue";
import Tweet from "@/Components/Tweet.vue";

defineProps({
  tweets: Array,
});
</script>
