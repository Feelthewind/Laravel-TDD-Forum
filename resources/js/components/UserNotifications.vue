<template>
  <div
    class="dropdown"
    v-if="notifications.length"
  >
    <button
      class="btn btn-secondary dropdown-toggle"
      type="button"
      id="dropdownMenuButton"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      Notifications
    </button>

    <div
      class="dropdown-menu"
      aria-labelledby="dropdownMenuButton"
    >
      <a
        class="dropdown-item"
        v-for="notification in notifications"
        :key="notification.id"
        :href="notification.data.link"
        v-text="notification.data.message"
        @click="markAsRead(notification)"
      ></a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return { notifications: false };
  },

  created() {
    axios
      .get("/profiles/" + window.App.user.name + "/notifications")
      .then(response => (this.notifications = response.data));
  },

  methods: {
    markAsRead(notification) {
      axios.delete(
        "/profiles/" +
          window.App.user.name +
          "/notifications/" +
          notification.id
      );
    }
  }
};
</script>

<style>
</style>
