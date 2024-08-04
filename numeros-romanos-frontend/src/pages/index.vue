<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <v-container>
    <v-row justify="center">
      <v-col
        cols="auto"
        align-self="center"
      >
        <v-card width="100%">
          <v-tabs
            v-model="tab"
            align-tabs="center"
            color="deep-purple-accent-4"
          >
            <v-tab :value="1">
              Números Romanos
            </v-tab>

            <v-tab :value="2">
              Números Inteiros
            </v-tab>
          </v-tabs>

          <v-tabs-window v-model="tab">
            <v-tabs-window-item :value="1">
              <v-card>
                <v-card-title class="text-center pa-3">
                  Transforme um número INTEIRO em um Número Romano!
                </v-card-title>

                <v-row class="py-8 pa-3">
                  <v-col>
                    <v-text-field
                      v-model="numeroArabico"
                      :rules="numeroRomanosRules"
                      color="blue-darken-4"
                      hide-spin-buttons
                      label="Número Inteiro"
                      variant="outlined"
                      placeholder="Digite um número"
                      type="number"
                      autofocus
                      prepend-icon="mdi-numeric-1"
                      @keydown.enter="transformaNumeroRomano"
                    />
                  </v-col>
                </v-row>

                <v-card-actions
                  class="pa-3"
                >
                  <v-btn
                    :disabled="!isValidRomano"
                    block
                    variant="tonal"
                    color="blue-darken-4"
                    @click="transformaNumeroRomano"
                  >
                    Transformar em Romano
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-tabs-window-item>

            <v-tabs-window-item :value="2">
              <v-card>
                <v-card-title class="text-center pa-3">
                  Transforme um número ROMANO em um Número Inteiro!
                </v-card-title>
                
                <v-row class="py-8 pa-3">
                  <v-col>
                    <v-text-field
                      v-model="numeroRomano"
                      :rules="numeroArabicoRules"
                      color="success"
                      hide-spin-buttons
                      label="Número Romano"
                      variant="outlined"
                      placeholder="Digite um número romano"
                      type="text"
                      prepend-icon="mdi-roman-numeral-2"
                      @keydown.enter="transformaNumeroArabico"
                    />
                  </v-col>
                </v-row>

                <v-card-actions
                  class="pa-3"
                  color="orange"
                >
                  <v-btn
                    :disabled="!isValidArabico"
                    block
                    variant="tonal"
                    color="success"
                    @click="transformaNumeroArabico"
                  >
                    Transformar Número em Inteiro
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-tabs-window-item>
          </v-tabs-window>
        </v-card>

        <v-overlay
          :model-value="overlay"
          class="align-center justify-center"
          persistent
        >
          <v-progress-circular
            color="primary"
            size="64"
            indeterminate
          />
        </v-overlay>

        <DialogNumero
          :title="dialogTitle"
          :subtitle="dialogSubtitle"
          :valor-dialog="numeroResponse"
          :dialog="dialog"
          @update:dialog="dialog = $event"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import DialogNumero from '@/components/DialogNumero.vue';

const overlay = ref(false);
const tab = ref(1);
const dialog = ref(false);

const numeroArabico = ref(null);

const numeroRomano = ref(null);

const dialogTitle = ref('');
const dialogSubtitle = ref('');
const numeroResponse = ref(null);

const numeroRomanosRules = [
  v => !!v || 'O campo número é obrigatório.',
  v => Number.isInteger(Number(v)) || 'O campo número deve ser um inteiro.',
  v => v >= 1 || 'O número deve ser no mínimo 1.',
  v => v < 4000 || 'O número máximo é 3999.'
];

const isValidRomano = computed(() => {
  return numeroRomanosRules.every(rule => rule(numeroArabico.value) === true);
});

const transformaNumeroRomano = async () => {
  if (!isValidRomano.value) {
    return;
  }
  try {
    overlay.value = true;
    const response = await axios.post('/api/romano', { numero_arabico: numeroArabico.value });
    
    numeroResponse.value = response.data.numero_romano;

    dialogTitle.value = `O número digitado foi ${numeroArabico.value}`;
    dialogSubtitle.value = 'Em números Romanos ficaria';
    
    dialog.value = true;
  } catch (error) {
    console.error('Erro ao converter número:', error);
  } finally {
    overlay.value = false;
  }
};

const numeroArabicoRules = [
  v => !!v || 'O campo número romano é obrigatório.',
  v => /^[MDCLXVI]+$/i.test(v) || 'O campo deve conter apenas os caracteres M D C L X V I.',
];

const isValidArabico = computed(() => {
  return numeroArabicoRules.every(rule => rule(numeroRomano.value) === true);
});

const transformaNumeroArabico = async () => {
  if (!isValidArabico.value) {
    return;
  }

  try {
    overlay.value = true;
    const response = await axios.post('/api/arabico', { numero_romano: numeroRomano.value });
    
    numeroResponse.value = response.data.numero_arabico;

    dialogTitle.value = `O número Romano digitado foi ${numeroRomano.value}`;
    dialogSubtitle.value = 'Em números Reais ficaria';

    dialog.value = true; 
  } catch (error) {
    console.error('Erro ao converter número:', error);
  } finally {
    overlay.value = false;
  }
};

watch(numeroRomano, (newValue) => {
  numeroRomano.value = newValue.toUpperCase()
})
</script>