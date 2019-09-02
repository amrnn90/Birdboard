<template>
  <modal name="create-project" classes="card py-8 px-10 rounded-lg shadow-lg" height="auto">
    <base-form @error-focus="doFocus" action="/projects" @success="handleSuccess" @fail="handleFail" #default="{form}">
      <h2 class="mb-10 text-2xl text-gray-800 text-center">Let's Start Something New</h2>
      <div class="flex">
        <div class="flex-1 mr-4">

          <form-field name="title" #default="{on, props}">
            <input ref="title" type="text" v-on="on" v-bind="props"  autofocus />
          </form-field>

          <form-field name="description" #default="{on, props}" class="mt-4">
            <textarea ref="description" v-on="on" v-bind="props" />
          </form-field>
        </div>

        <div class="flex-1 ml-4">
            <form-field label="Need some tasks?" name="tasks" #default="{on, props}">
              <tasks-input v-on="on" v-bind="props" />
            </form-field>
        </div>
      </div>


      <div class="flex justify-end mt-4">
        <button class="button" type="submit">Create Project</button>
        <button
          type="button"
          class="button bg-white border border-blue-400 text-blue-400 ml-4"
          @click="$modal.hide('create-project')"
        >Cancel</button>
      </div>
      <!-- <pre>{{form}}</pre> -->
    </base-form>
  </modal>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {};
  },
  methods: {
    handleSuccess(data) {
      location = data.message;
    },
    handleFail(response) {
      // this.errors = response.data.errors;
    },
    doFocus(errorComponents) {
      this.$refs[errorComponents[0].name].focus();
    }
  }
};
</script>

<style>
</style>