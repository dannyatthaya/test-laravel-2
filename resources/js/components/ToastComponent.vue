<template>
  <NotificationGroup group="toast">
    <div class="fixed inset-0 flex items-end justify-end p-6 px-4 py-6 pointer-events-none">
      <div class="w-full max-w-sm">
        <Notification
          v-slot="{ notifications }"
          enter="transform ease-in duration-300 transition"
          enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
          enter-to="translate-y-0 opacity-100 sm:translate-x-0"
          leave="transition ease-out duration-500"
          leave-from="opacity-100"
          leave-to="opacity-0"
          move="transition duration-500"
          move-delay="delay-300"
        >
          <div
            class="flex w-full max-w-sm mx-auto mt-4 overflow-hidden bg-gray-50 rounded-lg border border-black"
            v-for="notification in notifications"
            :key="notification.id"
          >
            <div class="px-4 py-2 -mx-3">
              <div class="mx-3">
                <span class="font-semibold uppercase text-green-500">{{ notification.title }}</span>
                <p class="text-sm text-black">{{ notification.text }}</p>
              </div>
            </div>
          </div>
        </Notification>
      </div>
    </div>
  </NotificationGroup>
</template>

<script>
import { Notification, NotificationGroup } from "notiwind";

export default {
  components: {
    Notification,
    NotificationGroup,
  },
}

</script>