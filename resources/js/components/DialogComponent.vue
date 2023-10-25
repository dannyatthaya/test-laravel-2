<template>
  <TransitionRoot
    as="template"
    :show="open"
  >
    <Dialog
      as="div"
      class="relative z-10"
      @close="closeDialog"
    >
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-black"
            >
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <DialogTitle
                      as="h3"
                      class="text-xl font-semibold leading-6 text-gray-900 uppercase"
                    >
                      Delete Currency Data?
                    </DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-black">
                        Are you sure you want to delete all currency data? All of your data
                        will be permanently removed. This action cannot be undone.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="border-t border-black px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button
                  type="button"
                  class="outline-none border border-black inline-flex w-full justify-center bg-white px-3 py-2 text-sm font-semibold text-black hover:bg-black hover:text-white sm:ml-3 sm:w-auto"
                  @click="onYes"
                >
                  Delete
                </button>
                <button
                  type="button"
                  class="mt-3 outline-none border border-black inline-flex w-full justify-center bg-white px-3 py-2 text-sm font-semibold text-black hover:bg-black hover:text-white sm:mt-0 sm:w-auto"
                  @click="onNo"
                  ref="cancelButtonRef"
                >
                  Cancel
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

export default {
  components: {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
  },
  computed: {
    open() {
      return this.$dialog.dialog.value;
    }
  },
  methods: {
    onYes() {
      if (this.$dialog.onYes.value) {
        this.$dialog.onYes.value();
      }

      this.closeDialog();
    },
    onNo() {
      if (this.$dialog.onNo.value) {
        this.$dialog.onNo.value();
      }

      this.closeDialog();
    },
    closeDialog() {
      this.$dialog.closeDialog();
    }
  }
}
</script>