<template>
  <div>
    <div class="mt-1 mb-2" v-for="(task, i) in value" :key="i">
      <input type="text" class="input" v-model="task.body" @keydown.enter.prevent="taskEnter(i)" @keyup.backspace="taskBackspace(i)" ref="task" />
    </div>

    <button type="button" class="flex items-center content-center mt-4" @click="addTask">
      <span
        class="relative inline-block border-2 border-gray-500 text-gray-500 h-4 w-4 rounded-full text-center"
      >
        <span
          class="absolute text-base font-bold"
          style="left: 50%; top: 50%; transform: translate(-50%, -50%)"
        >+</span>
      </span>
      <span class="text-gray-600 ml-2 text-xs">Add New Task Field</span>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Array,
      default: () => ([{body: ''}])
    }
  },
  methods: {
    addTask() {
      this.$emit('input', [...this.value, {body: ''}]);
      this.$nextTick(() => {
        this.$refs.task[this.value.length - 1].focus();
      });
    },
    taskBackspace(index) {
      // if (index == this.value.length-1 && this.value[index].body == "") {
      //   this.$emit('input', [...this.value.slice(0, -1)])
      // }
    },
    taskEnter(index) {
      index == this.value.length - 1 ? this.addTask() : null;
    }
  },
  created() {
    this.$emit('input', this.value);
  }
};
</script>

<style scoped>

</style>>