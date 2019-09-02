<template>
  <div>
    <label :for="name" class="label">{{inputLabel}}</label>

    <div class="mt-1">
      <slot :on="inputOn" :props="inputProps"></slot>
      <div v-if="error" class="input__error" role="alert">{{error}}</div>
    </div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: ["name", "label"],
  computed: {
    inputOn() {
      return {
        input: this.handleInput
      };
    },
    inputProps() {
      return {
        id: this.name,
        name: this.name,
        value: this.value,
        class: {
          input: true,
          "input--error": this.sharedForm.errors[this.name]
        }
      };
    },
    value() {
      return this.sharedForm.fields[this.name];
    },
    error() {
      return (
        this.sharedForm.errors[this.name] &&
        this.sharedForm.errors[this.name][0]
      );
    },
    inputLabel() {
      return this.label === undefined
        ? this.name.charAt(0).toUpperCase() + this.name.slice(1)
        : this.label;
    }
  },
  watch: {
    error(newState) {
      if (newState) {
        this.sharedForm.errorComponents = [
          ...this.sharedForm.errorComponents,
          { name: this.name }
        ];
      }
    }
  },
  data() {
    return {};
  },
  methods: {
    initValue() {
      const { sharedForm } = this;
      const current = sharedForm.fields[this.name];

      sharedForm.fields = {
        ...sharedForm.fields,
        [this.name]: Object.is(current, undefined) ? null : current
      };
    },
    handleInput(evOrValue) {
      let newValue;
      if (typeof evOrValue === "object" && evOrValue.target) {
        newValue = evOrValue.target.value;
      } else {
        newValue = evOrValue;
      }
      const { sharedForm } = this;
      sharedForm.fields = {
        ...sharedForm.fields,
        [this.name]: newValue
      };
      sharedForm.errors[this.name] = null;
    }
  },
  mounted() {
    this.initValue();
  },
  inject: ["sharedForm"]
};
</script>

<style>
</style>