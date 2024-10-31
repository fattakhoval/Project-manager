<template>
    <form @submit.prevent="submitForm">
      <div>
        <label for="title">Title:</label>
        <input type="text" v-model="task.title" required />
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea v-model="task.description"></textarea>
      </div>
      <div>
        <label for="project_id">Project ID:</label>
        <input type="text" v-model="task.project_id" required />
      </div>
      <div>
        <label for="user_id">User ID:</label>
        <input type="text" v-model="task.user_id" required />
      </div>
      <div>
        <label for="priority">Priority:</label>
        <select v-model="task.priority" required>
          <option value="Низкий">Низкий</option>
          <option value="Средний">Средний</option>
          <option value="Высокий">Высокий</option>
        </select>
      </div>
      <div>
        <label for="status">Status:</label>
        <select v-model="task.status" required>
          <option value="Назначена">Назначена</option>
          <option value="Выполняется">Выполняется</option>
          <option value="Завершена">Завершена</option>
        </select>
      </div>
      <div>
        <label for="start_date">Start Date:</label>
        <input type="date" v-model="task.start_date" />
      </div>
      <div>
        <label for="end_date">End Date:</label>
        <input type="date" v-model="task.end_date" />
      </div>
      <button type="submit">Create Task</button>
    </form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        task: {
          title: '',
          description: '',
          project_id: '',
          user_id: '',
          priority: 'Низкий',
          status: 'Назначена',
          start_date: '',
          end_date: '',
        },
      };
    },
    methods: {
      submitForm() {
        this.$emit('create-task', { ...this.task });
        this.resetForm();
      },
      resetForm() {
        this.task = {
          title: '',
          description: '',
          project_id: '',
          user_id: '',
          priority: 'Низкий',
          status: 'Назначена',
          start_date: '',
          end_date: '',
        };
      },
    },
  };
  </script>
  