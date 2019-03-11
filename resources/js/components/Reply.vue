<template>
  <div
    :id="'reply-'+id"
    class="card"
    :class="isBest ? 'bg-success' : 'bg-light'"
  >
    <div class="card-header">
      <div class="level">
        <h5 class="flex">
          <a
            :href="'/profiles/' + data.owner.name"
            v-text="data.owner.name"
          >
          </a> said <span v-text="ago"></span>
        </h5>

        <div v-if="signedIn">
          <favorite :reply="data"></favorite>
        </div>
      </div>
    </div>

    <div class="card-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea
            class="form-control"
            v-model="body"
          ></textarea>
        </div>

        <button
          class="btn btn-xs btn-primary"
          @click="update"
        >Update</button>
        <button
          class="btn btn-xs btn-link"
          @click="editing = false"
        >Cancel</button>
      </div>

      <div
        v-else
        v-html="body"
      ></div>
    </div>

    <div class="panel-footer level">
      <div v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
        <button
          class="btn btn-xs mr-1"
          @click="editing = true"
        >Edit</button>
        <button
          class="btn btn-xs btn-danger mr-1"
          @click="destroy"
        >Delete</button>
      </div>

      <button
        class="btn btn-xs btn-default ml-a"
        @click="markBestReply"
        v-if="authorize('owns', reply.thread)"
      >Best Reply?</button>
    </div>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";
import moment from "moment";

export default {
  props: ["data"],

  components: { Favorite },

  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body,
      isBest: this.data.isBest,
      reply: this.data
    };
  },

  computed: {
    ago() {
      return moment(this.data.created_at + "Z").fromNow() + "...";
    }
  },

  created() {
    window.events.$on("best-reply-selected", id => {
      this.isBest = id === this.id;
    });
  },

  methods: {
    update() {
      axios
        .patch("/replies/" + this.data.id, {
          body: this.body
        })
        .catch(error => {
          flash(error.response.data, "danger");
        });

      this.editing = false;

      flash("Updated!");
    },

    destroy() {
      axios.delete("/replies/" + this.data.id);

      this.$emit("deleted", this.data.id);
    },

    markBestReply() {
      axios.post("/replies/" + this.data.id + "/best");

      window.events.$emit("best-reply-selected", this.data.id);
    }
  }
};
</script>