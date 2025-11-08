<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  categories: {
    type: Object,
    required: true
  },
  editingTransaction: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['submit', 'cancel']);

const newTransaction = ref({
  description: '',
  amount: 0,
  type: 'income',
  date: new Date().toISOString().split('T')[0],
  category: ''
});

watch(() => props.editingTransaction, (newVal) => {
  if (newVal) {
    newTransaction.value = { ...newVal };
  } else {
    newTransaction.value = {
      description: '',
      amount: 0,
      type: 'income',
      date: new Date().toISOString().split('T')[0],
      category: ''
    };
  }
});

const handleSubmit = () => {
  if (!newTransaction.value.description || newTransaction.value.amount === 0) {
    alert('Please fill in all fields correctly.');
    return;
  }
  emit('submit', newTransaction.value);
};

const handleCancel = () => {
  emit('cancel');
};
</script>

<template>
  <div>
    <h2 class="text-2xl font-bold mb-6">
      {{ editingTransaction ? 'Edit' : 'Tambah' }} Transaksi
    </h2>
    
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="form-control">
        <label class="label">
          <span class="label-text">Deskripsi</span>
        </label>
        <input 
          type="text" 
          v-model="newTransaction.description"
          placeholder="cth. Gaji Bulanan" 
          class="input input-bordered w-full" 
          required
        />
      </div>

      <div class="form-control">
        <label class="label">
          <span class="label-text">Nominal (Rp)</span>
        </label>
        <input 
          type="number" 
          v-model.number="newTransaction.amount"
          placeholder="e.g., 5000000" 
          class="input input-bordered w-full" 
          required
        />
      </div>

      <div class="form-control">
        <label class="label">
          <span class="label-text">Jenis</span>
        </label>
        <div class="join w-full">
          <button 
            type="button"
            :class="['btn join-item flex-1', { 'btn-primary': newTransaction.type === 'income' }]"
            @click="newTransaction.type = 'income'"
          >
            Pemasukan
          </button>
          <button 
            type="button"
            :class="['btn join-item flex-1', { 'btn-primary': newTransaction.type === 'expense' }]"
            @click="newTransaction.type = 'expense'"
          >
            Pengeluaran
          </button>
        </div>
      </div>

      <div class="form-control">
        <label class="label">
          <span class="label-text">Kategori</span>
        </label>
        <select 
          v-model="newTransaction.category"
          class="select select-bordered w-full"
        >
          <option disabled selected>Pilih Kategori</option>
          <option v-for="cat in categories[newTransaction.type]" :key="cat" :value="cat">
            {{ cat }}
          </option>
        </select>
      </div>

      <div class="modal-action pt-4">
        <button type="button" class="btn" @click="handleCancel">Batal</button>
        <button type="submit" class="btn btn-primary">
          {{ editingTransaction ? 'Update' : 'Tambah' }} Transaksi
        </button>
      </div>
    </form>
  </div>
</template>