<template>
<form @submit.prevent="submitForm">
      <div>
        <label for="name">Project Name:</label>
        <input type="text" v-model="newProject.name" required />
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea v-model="newProject.description"></textarea>
      </div>
      <div>
        <label for="start_date">Start Date:</label>
        <input type="date" v-model="newProject.start_date" required />
      </div>
      <div>
        <label for="end_date">End Date:</label>
        <input type="date" v-model="newProject.end_date" required />
      </div>
      <div>
      <label for="user_id">Manager ID:</label>
      <input type="text" v-model="newProject.user_id" readonly />
    </div>
      <button type="submit">Create Project</button>
</form>
</template>

<script>
export default {
    props: {
    user: {
      type: Object,
      required: true,
    },
  },
    data() {
        return {
        newProject: {
            name: '',
            description: '',
            user_id: this.user.id,
            start_date: '',
            end_date: '',
        },
        };
    },
    methods: {
        submitForm() {
        this.$emit('create-project', { ...this.newProject });
        this.resetForm();
        },
        resetForm() {
        this.project = {
            name: '',
            description: '',
            user_id: this.user.id,
            start_date: '',
            end_date: '',
        };
        },
    },
};
</script>