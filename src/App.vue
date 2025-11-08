<script setup>
import { ref, computed, onMounted } from 'vue';
import { themeChange } from 'theme-change'
import TransactionForm from './components/TransactionForm.vue';
import TransactionList from './components/TransactionList.vue';

const transactions = ref([
  { id: 1, description: 'Gaji Bulanan', amount: 5000000, type: 'income', date: '2024-05-01', category: 'Gaji' },
  { id: 2, description: 'Bayar Kos', amount: -1000000, type: 'expense', date: '2024-11-02', category: 'Housing' },
  { id: 3, description: 'Beli Makan', amount: -50000, type: 'expense', date: '2024-11-03', category: 'Food' },
  { id: 4, description: 'Freelance Project', amount: 2000000, type: 'income', date: '2024-11-04', category: 'Freelance' },
  { id: 5, description: 'Bensin Motor', amount: -100000, type: 'expense', date: '2024-11-05', category: 'Transport' },
]);

const filter = ref('all');
const editingTransaction = ref(null);
const isModalOpen = ref(false);

const categories = {
  income: ['Gaji', 'Freelance', 'Investasi', 'Lainnya'],
  expense: ['Makanan', 'Perumahan', 'Transportasi', 'Hiburan', 'Belanja', 'Tagihan', 'Lainnya']
};

const totalIncome = computed(() => {
  return transactions.value
    .filter(t => t.type === 'income')
    .reduce((acc, t) => acc + t.amount, 0);
});

const totalExpense = computed(() => {
  return transactions.value
    .filter(t => t.type === 'expense')
    .reduce((acc, t) => acc + Math.abs(t.amount), 0);
});

const balance = computed(() => {
  return totalIncome.value - totalExpense.value;
});

const filteredTransactions = computed(() => {
  const filtered = filter.value === 'all' 
    ? transactions.value 
    : transactions.value.filter(t => t.type === filter.value);
  return filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
});

const handleAddTransaction = (newTransaction) => {
  if (editingTransaction.value) {
    const index = transactions.value.findIndex(t => t.id === editingTransaction.value.id);
    transactions.value[index] = { ...newTransaction, id: editingTransaction.value.id };
  } else {
    transactions.value.push({ ...newTransaction, id: Date.now() });
  }
  isModalOpen.value = false;
  editingTransaction.value = null;
};

const deleteTransaction = (id) => {
  transactions.value = transactions.value.filter(transaction => transaction.id !== id);
};

const handleEditTransaction = (transaction) => {
  editingTransaction.value = transaction;
  isModalOpen.value = true;
};

const openAddModal = () => {
  editingTransaction.value = null;
  isModalOpen.value = true;
};

const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(number);
};

const formatCompactRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    notation: 'compact'
  }).format(Math.abs(number));
};
onMounted(() => {
  themeChange(false)
})
</script>

<template>
  <div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col bg-base-200">
      <!-- Navbar -->
      <div class="navbar bg-base-100 lg:hidden sticky top-0 z-30">
        <div class="flex-none">
          <label for="my-drawer-2" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
          </label>
        </div>
        <div class="flex-1">
          <a class="btn btn-ghost normal-case text-xl">Keuanganku</a>
        </div>
        <div class="flex-none">
          <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li><a data-set-theme="light">Light</a></li>
              <li><a data-set-theme="dark">Dark</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Page content here -->
      <main class="flex-1 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
          <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Dashboard</h1>
            <p class="text-base-content/70 mt-1">Overview Keuangan</p>
          </div>
          <div class="flex items-center mt-4 sm:mt-0">
            <div class="form-control mr-2">
              <input type="text" placeholder="Search..." class="input input-bordered w-24 md:w-auto" />
            </div>
            <button @click="openAddModal" class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
              Add Transaction
            </button>
          </div>
        </header>

        <!-- Stats -->
        <div class="card bg-base-100 shadow-lg mb-8">
          <div class="card-body">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div class="flex items-center">
                <div class="bg-success/20 text-success p-3 rounded-full mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" /></svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-base-content/70">Total Pemasukan</p>
                  <p class="text-2xl font-bold">{{ formatRupiah(totalIncome) }}</p>
                </div>
              </div>
              <div class="flex items-center">
                <div class="bg-error/20 text-error p-3 rounded-full mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" /></svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-base-content/70">Total Pengeluaran</p>
                  <p class="text-2xl font-bold">{{ formatRupiah(totalExpense) }}</p>
                </div>
              </div>
              <div class="flex items-center">
                <div class="bg-info/20 text-info p-3 rounded-full mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 6h12l3-6H3zm0 6v6m18-6v6" /></svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-base-content/70">Balance</p>
                  <p class="text-2xl font-bold">{{ formatRupiah(balance) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card bg-base-100 shadow-lg">
          <div class="card-body">
            <transaction-list 
              :transactions="filteredTransactions" 
              :filter="filter" 
              @update:filter="filter = $event" 
              @delete="deleteTransaction" 
              @edit="handleEditTransaction"
            />
          </div>
        </div>
      </main>
    </div> 
    <aside class="drawer-side">
      <label for="my-drawer-2" class="drawer-overlay"></label> 
      <ul class="menu p-4 w-60 min-h-full bg-base-100 text-base-content space-y-2">
        <!-- Sidebar content here -->
        <li class="menu-title">
          <span class="text-lg font-bold">Keuanganku</span>
        </li>
        <li><a class="active"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg> Dashboard</a></li>
        <li><a><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Reports</a></li>
        <li><a><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg> Settings</a></li>
        
        <div class="divider mt-auto"></div>
        
        <div class="px-4">
          <span class="text-sm font-semibold">Theme</span>
          <div class="flex justify-around mt-2">
            <button class="btn btn-sm btn-outline" data-set-theme="light" icon="sun">Light</button>
            <button class="btn btn-sm btn-outline" data-set-theme="dark" icon="moon">Dark</button>
          </div>
        </div>
      </ul>
    </aside>

    <!-- Modal -->
    <div class="modal" :class="{ 'modal-open': isModalOpen }">
      <div class="modal-box w-11/12 max-w-lg">
        <button @click="isModalOpen = false" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        <transaction-form 
          @submit="handleAddTransaction" 
          :categories="categories" 
          :editingTransaction="editingTransaction"
        />
      </div>
       <label class="modal-backdrop" @click="isModalOpen = false">Close</label>
    </div>
  </div>
</template>

<style>
/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>