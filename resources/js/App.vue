<template>
  <div class="container mx-auto my-8 space-y-4">
    <h1 class="text-4xl">
      Test Laravel II
    </h1>

    <div class="flex w-full">
      <button
        class="border border-black px-4 py-2 hover:text-white hover:bg-black transition-all duration-200 ease-in-out font-semibold uppercase text-sm outline-none"
        @click="showToast"
      >
        Delete Currency Data
      </button>
    </div>
  </div>

  <toast-component />
  <dialog-component />
</template>

<script>
import axios from "axios";

export default {
  name: 'App',
  methods: {
    showToast() {
      this.$dialog.openDialog(async () => {
        try {
          await this.onDeleteCurrency();

          this.$notify({
            group: "toast",
            title: "Notifikasi",
            text: "Proses berhasil ditambahkan pada Job"
          }, 5000);
        } catch (error) {
          this.$notify({
            group: "toast",
            title: "Notifikasi",
            text: `Proses gagal ditambahkan pada Job. Error: ${error}`
          }, 5000);
        }
      });
    },
    async onDeleteCurrency() {
      await axios.post("/api/currency/delete/all");
    }
  }
};
</script>
