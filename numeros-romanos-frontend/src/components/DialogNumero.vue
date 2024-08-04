<template>
  <v-dialog
    v-model="isDialogOpen"
    transition="dialog-bottom-transition"
    width="50%"
  >
    <v-card>
      <v-card-title class="pa-3">
        {{ title }}
      </v-card-title>

      <div class="pa-3">
        {{ subtitle }}
      </div>
      <v-card-text class="text-h2 pa-12 text-center">
        {{ valorDialog }}
      </v-card-text>

      <v-card-actions>
        <v-btn
          text="Fechar"
          variant="outlined"
          block
          color="red"
          @click="isDialogOpen = false"
        />
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    required: true
  },
  valorDialog: {
    type: String,
    required: true
  },
  dialog: {
    type: Boolean,
    required: true
  }
});

const emit = defineEmits(['update:dialog']);

const isDialogOpen = ref(props.dialog);

watch(() => props.dialog, (newVal) => {
  isDialogOpen.value = newVal;
});

watch(isDialogOpen, (newVal) => {
  emit('update:dialog', newVal);
});
</script>