<script setup>
import { ref, computed } from 'vue';

const transactions = ref([
  { id: 1, description: 'Gaji Bulanan', amount: 5000000, type: 'income' },
  { id: 2, description: 'Bayar Kos', amount: -1000000, type: 'expense' },
  { id: 3, description: 'Beli Makan', amount: -50000, type: 'expense' },
]);

const newTransaction = ref({
  description: '',
  amount: 0,
  type: 'income',
});

const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(number);
};

const totalIncome = computed(() => {
  return transactions.value
    .filter(t => t.type === 'income')
    .reduce((acc, t) => acc + t.amount, 0);
});

const totalExpense = computed(() => {
  return transactions.value
    .filter(t => t.type === 'expense')
    .reduce((acc, t) => acc + t.amount, 0);
});

const balance = computed(() => {
  return totalIncome.value + totalExpense.value;
});

const addTransaction = () => {
  if (!newTransaction.value.description || !newTransaction.value.amount) {
    return;
  }
  transactions.value.push({
    id: transactions.value.length + 1,
    ...newTransaction.value,
    amount: newTransaction.value.type === 'expense' ? -Math.abs(newTransaction.value.amount) : Math.abs(newTransaction.value.amount)
  });
  newTransaction.value.description = '';
  newTransaction.value.amount = 0;
};

const deleteTransaction = (id) => {
  transactions.value = transactions.value.filter(t => t.id !== id);
};
</script>

<template>
  <div class="navbar bg-base-100">
    <a class="btn btn-ghost normal-case text-xl">Keuanganku</a>
  </div>

  <div class="container mx-auto p-4">
    <div class="stats shadow">
      <div class="stat">
        <div class="stat-title">Pemasukan</div>
        <div class="stat-value text-success">{{ formatRupiah(totalIncome) }}</div>
      </div>

      <div class="stat">
        <div class="stat-title">Pengeluaran</div>
        <div class="stat-value text-error">{{ formatRupiah(totalExpense) }}</div>
      </div>

      <div class="stat">
        <div class="stat-title">Saldo</div>
        <div class="stat-value">{{ formatRupiah(balance) }}</div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <h2 class="text-2xl font-bold mb-4">Tambah Transaksi</h2>
        <form @submit.prevent="addTransaction" class="space-y-4">
          <div>
            <label class="label">
              <span class="label-text">Deskripsi</span>
            </label>
            <input type="text" v-model="newTransaction.description" placeholder="Deskripsi" class="input input-bordered w-full" />
          </div>
          <div>
            <label class="label">
              <span class="label-text">Jumlah</span>
            </label>
            <input type="number" v-model.number="newTransaction.amount" placeholder="Jumlah" class="input input-bordered w-full" />
          </div>
          <div>
            <label class="label">
              <span class="label-text">Tipe</span>
            </label>
            <select v-model="newTransaction.type" class="select select-bordered w-full">
              <option value="income">Pemasukan</option>
              <option value="expense">Pengeluaran</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
      </div>

      <div>
        <h2 class="text-2xl font-bold mb-4">Daftar Transaksi</h2>
        <div class="overflow-x-auto">
          <table class="table w-full">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="transaction in transactions" :key="transaction.id">
                <td>{{ transaction.description }}</td>
                <td :class="transaction.type === 'income' ? 'text-success' : 'text-error'">
                  {{ formatRupiah(transaction.amount) }}
                </td>
                <td>
                  <button @click="deleteTransaction(transaction.id)" class="btn btn-xs btn-error">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>