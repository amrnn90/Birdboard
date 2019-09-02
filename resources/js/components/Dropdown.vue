<template>
  <div class="dropdown relative">
    <div class="dropdown__trigger" @click="toggle" ref="trigger">
      <slot name="trigger"></slot>
    </div>
    <div 
     v-show="isOpen"
     @click.stop
      class="dropdown__menu py-2 absolute bg-white shadow"
      :class="{'left-0': anchor == 'left', 'right-0': anchor == 'right'}"
     :style="{width: this.width}"
    >
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    width: { default: "auto" },
    anchor: {default: "left"}
  },
  data() {
    return {
      isOpen: false
    };
  },
  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
    close() {
      this.isOpen = false;
    },
    onDocumentClick(ev) {
      const triggerNode = this.$refs.trigger;
      if (ev.target == triggerNode || triggerNode.contains(ev.target)) return;
      this.close();
    }
  },
  watch: {
    isOpen(isOpen) {
      if (isOpen) {
        document.addEventListener("click", this.onDocumentClick);
        // document.addEventListener('keyup', this.close)
      } else {
        document.removeEventListener("click", this.close);
      }
    }
  }
};
</script>

<style lang="scss">
.dropdown__item {
  @apply block px-4 py-1;

  &:hover {
    @apply bg-gray-200;
  }
}
</style>