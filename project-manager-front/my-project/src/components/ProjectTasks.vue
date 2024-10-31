<template>
  <div>
    <h3>Tasks for Project: {{ projectName }}</h3>
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <h4>{{ task.title }}</h4>
        <p>{{ task.description }}</p>
        <p><strong>Status:</strong> {{ task.status }}</p>

        <select v-model="task.user_id" @change="assignUser(task.id, task.user_id)">
          <option value=""></option>
          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>


        <select v-model="task.status" @change="updateStatus(task.id, task.status)">
          <option value="Назначена">Назначена</option>
          <option value="Выполняется">Выполняется</option>
          <option value="Завершена">Завершена</option>
        </select>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    projectId: {
      type: String,
      required: true,
    },
    projectName: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      tasks: [],
      users: [],
    };
  },
  created() {
    this.fetchTasks();
    this.fetchNonAdminUsers();
  },
  methods: {
    async fetchNonAdminUsers() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/manager/users/non-admin');
          if (!response.ok) {
            throw new Error('Failed to fetch users');
          }
          const data = await response.json();
          this.users = data; // Сохраняем пользователей в состоянии компонента
        } catch (error) {
          console.error('Error fetching non-admin users:', error);
        }
      },
    async assignUser(taskId, userId) {
      if (userId) {
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/manager/tasks/${taskId}/assign`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: userId }),
            credentials: 'include',
          });

          if (!response.ok) {
            throw new Error('Failed to assign user');
          }

          const updatedTask = await response.json();
          console.log('User assigned:', updatedTask);
          // Обновите задачу в локальном состоянии, если необходимо
          this.fetchTasks();
        } catch (error) {
          console.error('Error assigning user:', error);
        }
      }
    },
    async updateStatus(taskId, status) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/manager/tasks/${taskId}/status`, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ status }),
          credentials: 'include',
        });

        if (!response.ok) {
          throw new Error('Failed to update status');
        }

        const updatedTask = await response.json();
        console.log('Status updated:', updatedTask);
        // Обновите задачу в локальном состоянии, если необходимо
        this.fetchTasks();
      } catch (error) {
        console.error('Error updating status:', error);
      }
    },
    async fetchTasks() {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/manager/projects/${this.projectId}/tasks`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
          credentials: 'include',
        });
        
        if (!response.ok) {
          throw new Error('Failed to fetch tasks');
        }

        const data = await response.json();
        this.tasks = data.data; // Обратите внимание на это изменение
      } catch (error) {
        console.error("Ошибка при получении задач:", error);
      }
    },
  },
};
</script>

<style scoped>
/* Да и так красиво, зачем стили, минимализм все дела */
</style>