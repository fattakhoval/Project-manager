<template>
    <div class="projects">

      <ul>
        <li v-for="project in data" :key="project.id" class="project-item">
          <router-link :to="{ name: 'project-tasks', params: { projectId: project.id }, query: { projectName: project.name } }">
          <h3>{{ project.name }}</h3>
        </router-link>
          <p>{{ project.description }}</p>
          <p><strong>Status:</strong> {{ project.status }}</p>
          <p><strong>Start Date:</strong> {{ formatDate(project.start_date) }}</p>
          <p><strong>End Date:</strong> {{ formatDate(project.end_date) }}</p>

          <div class="assignments" v-if="user && user.role === 'Админ'">
            <button @click="assignManager(project.id)">Assign Manager</button>
            <button @click="assignExecutor(project.id)">Assign Executor</button>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      data: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        user: null,
      };
    },
    created() {
      const userData = localStorage.getItem('user');
      if (userData) {
        this.user = JSON.parse(userData);
      } else {
        this.$router.push('/login');
      }
    },
    methods: {
      formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString(undefined, options);
      },
      async assignManager(projectId) {
      const userId = prompt("Введите ID пользователя для назначения руководителем проекта:");
      if (userId) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/admin/projects/${projectId}/assign-manager`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: userId }),
          });
          const data = await response.json();
          console.log("Менеджер назначен:", data);
        } catch (error) {
          console.error("Ошибка при назначении менеджера:", error);
        }
      }
    },
    async assignExecutor(projectId) {
      const userId = prompt("Введите ID пользователя для назначения исполнителем:");
      if (userId) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/admin/projects/${projectId}/assign-executor`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: userId }),
          });
          const data = await response.json();
          console.log("Исполнитель назначен:", data);
          // Обновите состояние или выполните другие действия после назначения
        } catch (error) {
          console.error("Ошибка при назначении исполнителя:", error);
        }
      }
    },
    },
  };
  </script>
  
  <style scoped>
  .projects {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
  }
  
  .project-item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
  }
  
  .tasks {
    margin-top: 10px;
  }
  
  .tasks ul {
    list-style-type: disc;
    padding-left: 20px;
  }
  </style>
  