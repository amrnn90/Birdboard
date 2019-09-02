<template>
  <form :action="action" @submit.prevent="submit">
    <slot :form="sharedForm"></slot>
  </form>
</template>

<script>
import axios from "axios";

export default {
  props: {
    action: {},
    initialValue: { type: Object, default: () => ({}) },
  },
  data() {
    return {
      sharedForm: {
        fields: this.initialValue,
        errors: {},
        errorComponents: []
      },
      shouldFocus: true,
    };
  },
  computed: {
    form() {
      return this.sharedForm.fields;
    }
  },
  watch: {
    "sharedForm.errorComponents": {
      handler() {
        const { sharedForm } = this;
        if (sharedForm.errorComponents.length && this.shouldFocus) {

            this.shouldFocus = false;
            this.$nextTick(() => {
              this.$emit('error-focus', sharedForm.errorComponents);
              this.shouldFocus = true;
              sharedForm.errorComponents = [];
            });

        }
      }
    }
  },
  methods: {
    submit() {
      this.clearErrors();
      axios
        .post(this.action, this.form)
        .then(({ data }) => {
          this.$emit("success", data);
        })
        .catch(({ response }) => {
          this.sharedForm.errors = response.data.errors;
          this.$emit("fail", response);
        });
    },
    clearErrors() {
      this.sharedForm.errors = {};
    }
  },
  provide() {
    return {
      sharedForm: this.sharedForm
    };
  }
};
</script>

<style>
</style>