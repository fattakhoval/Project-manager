<template>
    <div class="tasks">
      <ul v-if="data.length > 0">
        <li v-for="task in data" :key="task.id" class="task-item">
          <h3>{{ task.title }}</h3>
          <p>{{ task.description }}</p>
          <p><strong>Статус:</strong> {{ task.status }}</p>
          <p class="priority"><strong>Приоритет:</strong> {{ task.priority }}</p>
          <p><strong>Дата начала:</strong> {{ formatDate(task.start_date) }}</p>
          <p><strong>Дата окончания:</strong> {{ formatDate(task.end_date) }}</p>
        </li>
      </ul>
      <p v-else>Пока нет задач для пользователя.</p> <!-- Сообщение, если задач нет -->
    </div>
  </template>
  
  <script>
  
  export default {
    props: {
      data: {
        type: Array,
        required: true,
      }
    },
    data() {
      return {
        isModalOpen: false,
        editedTask: {},
      };
    },
    methods: {

      

      formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString(undefined, options);
      },
    }
  };
  </script>
  
  <style scoped>
  .tasks {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
  }
  
  .task-item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
  }

  .priority {
    background-color: green;
  }
  </style>
  