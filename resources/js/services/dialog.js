import { ref } from 'vue';

const dialog = ref(false);

const onYes = ref(undefined);
const onNo = ref(undefined);

function openDialog(onYesCallback, onNoCallback) {
  onYes.value = onYesCallback;
  onNo.value = onNoCallback;

  dialog.value = true;
}

function closeDialog() {
  onYes.value = undefined;
  onNo.value = undefined;

  dialog.value = false;
}

export default { dialog, onYes, onNo, openDialog, closeDialog };
