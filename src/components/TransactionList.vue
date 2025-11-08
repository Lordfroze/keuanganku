<script setup>
const props = defineProps({
  transactions: {
    type: Array,
    required: true
  },
  filter: {
    type: String,
    required: true
  }
});

const emit = defineEmits(['delete', 'edit', 'update:filter']);

const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(Math.abs(number));
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('id-ID', options);
};

const deleteTransaction = (id) => {
  emit('delete', id);
};
</script>

<template>
  <div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
      <h2 class="text-xl font-bold mb-4 sm:mb-0">Transaksi Terakhir</h2>
      <div class="tabs tabs-boxed bg-base-200/50">
        <a 
          :class="['tab', { 'tab-active': filter === 'all' }]"
          @click="emit('update:filter', 'all')"
        >
          All
        </a>
        <a 
          :class="['tab', { 'tab-active': filter === 'income' }]"
          @click="emit('update:filter', 'income')"
        >
          Pemasukan
        </a>
        <a 
          :class="['tab', { 'tab-active': filter === 'expense' }]"
          @click="emit('update:filter', 'expense')"
        >
          Pengeluaran
        </a>
      </div>
    </div>

    <!-- Desktop Table -->
    <div class="overflow-x-auto hidden sm:block">
      <table class="table w-full">
        <tbody>
          <tr v-for="transaction in transactions" :key="transaction.id" class="hover">
            <td class="w-full">
              <div class="font-bold">{{ transaction.description }}</div>
              <div class="text-sm opacity-50">{{ formatDate(transaction.date) }}</div>
            </td>
            <td>~
              <span :class="transaction.type === 'income' ? 'text-success' : 'text-error'" class="font-bold">
                {{ transaction.type === 'income' ? '+' : '-' }} {{ formatRupiah(transaction.amount) }}
              </span>
              <br>
              <span class="badge badge-ghost badge-sm">{{ transaction.category }}</span>
            </td>
            <td class="text-right">
              <div class="flex justify-end gap-2">
                <button @click="$emit('edit', transaction)" class="btn btn-ghost btn-xs">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z" /></svg>
                </button>
                <button @click="deleteTransaction(transaction.id)" class="btn btn-ghost btn-xs">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Mobile List -->
    <div class="sm:hidden">
      <div v-for="transaction in transactions" :key="transaction.id" class="bg-base-100 rounded-lg shadow mb-4 p-4">
        <div class="flex justify-between items-start">
          <div>
            <div class="font-bold">{{ transaction.description }}</div>
            <div class="text-sm opacity-50">{{ formatDate(transaction.date) }}</div>
          </div>
          <div class="text-right">
            <span :class="transaction.type === 'income' ? 'text-success' : 'text-error'" class="font-bold text-lg">
              {{ transaction.type === 'income' ? '+' : '-' }} {{ formatRupiah(transaction.amount) }}
            </span>
            <div class="text-sm opacity-50">{{ transaction.category }}</div>
          </div>
        </div>
        <div class="flex justify-end gap-2 mt-4">
          <button @click="$emit('edit', transaction)" class="btn btn-ghost btn-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z" /></svg>
            Edit
          </button>
          <button @click="deleteTransaction(transaction.id)" class="btn btn-ghost btn-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            Delete
          </button>
        </div>
      </div>
    </div>

  </div>
</template>