<template>
    <div class="main-page" v-if="user">
      <div class="content">
        <div class="role-actions">
          <button @click="selectSection('tasks')">Tasks</button>
        </div>
        <div class="info-box" v-if="selectedSection">
          <h2>{{ selectedSection.toUpperCase() }}</h2>
          <component :is="currentComponent" :data="sectionData || []"></component>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import TasksComponent from './TasksComponent.vue';
  
  export default {
    props: {
      data: Object,
    },
    data() {
      return {
        selectedSection: 'tasks', // По умолчанию выбираем вкладку задач
        sectionData: [], // Инициализируем как пустой массив
      };
    },
    computed: {
      currentComponent() {
        switch (this.selectedSection) {
          case 'tasks':
            return TasksComponent;
          default:
            return null;
        }
      },
    },
    created() {
      const userData = localStorage.getItem('user');
      if (userData) {
        this.user = JSON.parse(userData);
        this.fetchSectionData(this.selectedSection); // Загружаем данные задач при создании
      } else {
        this.$router.push('/login');
      }
    },
    methods: {
      selectSection(section) {
        this.selectedSection = section;
        this.fetchSectionData(section);
      },
      fetchSectionData(section) {
        let url = '';
        switch (section) {
          case 'tasks':
            url = 'http://127.0.0.1:8000/api/tasks'; // URL для получения задач исполнителя
            break;
        }
        fetch(url, {
          method: 'GET',
          credentials: 'include',
        })
        .then(response => response.json())
        .then(data => {
          this.sectionData = data.data; // Предполагаем, что данные находятся в data
        })
        .catch(error => console.error('Error fetching data:', error));
      },
    },
    components: {
      TasksComponent,
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
  