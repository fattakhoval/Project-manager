<template>
  <div class="main-page" v-if="user">
    <div class="content">
      <div class="role-actions">
        <button v-if="user.role === 'Админ'" @click="selectSection('projects')">Projects</button>
        <button v-if="user.role === 'Админ'" @click="selectSection('tasks')">Tasks</button>
        <button v-if="user.role === 'Админ'" @click="selectSection('users')">Users</button>
      </div>
      <div class="info-box" v-if="selectedSection">
        <h2>{{ selectedSection.toUpperCase() }}</h2>
        <component :is="currentComponent" :data="sectionData || []"
        @userDeleted="handleUserDeleted"
        @userUpdated="handleUserUpdated"
        @userCreated="handleUserCreated"
        ></component>
      </div>
    </div>
  </div>
</template>

<script>
import ProjectsComponent from './ProjectsComponent.vue';
import TasksComponent from './TasksComponent.vue';
import UsersComponent from './UsersComponent.vue';

export default {
  props: {
    user: Object,
  },
  data() {
    return {
      selectedSection: null,
      sectionData: [],
    };
  },
  computed: {
    currentComponent() {
      switch (this.selectedSection) {
        case 'projects':
          return ProjectsComponent;
        case 'tasks':
          return TasksComponent;
        case 'users':
          return UsersComponent;
        default:
          return null;
      }
    },
  },
  methods: {
    handleUserCreated(newUser) {
      this.sectionData.push(newUser);
    },
    selectSection(section) {
      this.selectedSection = section;
      this.fetchSectionData(section);
    },
    fetchSectionData(section) {
      let url = '';
      switch (section) {
        case 'projects':
          url = 'http://127.0.0.1:8000/api/admin/projects/';
          break;
        case 'tasks':
          url = 'http://127.0.0.1:8000/api/manager/tasks';
          break;
        case 'users':
          url = 'http://127.0.0.1:8000/api/admin/users';
          break;
      }
      fetch(url, {
        method: 'GET',
        credentials: 'include',
      })
      .then(response => response.json())
      .then(data => {
        this.sectionData = data;
      })
      .catch(error => console.error('Error fetching data:', error));
    },
    handleUserDeleted(userId) {
      // Удаляем пользователя из sectionData
      this.sectionData = this.sectionData.filter(user => user.id !== userId);
    },
    handleUserUpdated(updatedUser) {
      const index = this.sectionData.findIndex(user => user.id === updatedUser.id);
      if (index !== -1) {
        // Заменяем объект пользователя в массиве
        this.sectionData.splice(index, 1, updatedUser);
        // Присваиваем новый массив для реактивного обновления
        this.sectionData = [...this.sectionData];
      }
    },
  },
  components: {
    ProjectsComponent,
    TasksComponent,
    UsersComponent,
  },
};
</script>

<style scoped>
.content {
  padding: 20px;
}
.role-actions {
  margin-bottom: 20px;
}
.info-box {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 5px;
}
</style>
