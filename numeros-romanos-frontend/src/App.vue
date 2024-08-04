<template>
  <v-container>
    <v-app :theme="isDarkMode ? 'dark' : 'light'">
      <v-app-bar>
        <v-row justify="center">
          <v-btn
            icon
            class="text-right"
            @click="toggleDarkMode()"
          >
            <v-icon>mdi-theme-light-dark</v-icon>
          </v-btn>
        </v-row>
      </v-app-bar>
    
      <v-main>
        <router-view />
      </v-main>
    </v-app>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'

const isDarkMode = ref(true)

function toggleDarkMode() {
  isDarkMode.value = !isDarkMode.value;
}
</script>
