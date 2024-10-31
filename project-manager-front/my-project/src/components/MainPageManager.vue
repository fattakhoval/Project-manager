<template>
    <div class="main-page" v-if="user">
      <div class="content">
        <div class="role-actions kanit-bold">
          <button v-if="user.role === 'Руководитель проекта'" @click="selectSection('projects')" class="kanit-bold">Projects</button>
          <button v-if="user.role === 'Руководитель проекта'" @click="selectSection('tasks')" class="kanit-bold">Tasks</button>
          <button v-if="user.role === 'Руководитель проекта'" @click="openModal('task')" class="kanit-bold">Create Task</button>
          <button v-if="user.role === 'Руководитель проекта'" @click="openModal('project')" class="kanit-bold">Create Project</button>
        </div>
        <div class="info-box" v-if="selectedSection">
          <h2>{{ selectedSection.toUpperCase() }}</h2>
          <component :is="currentComponent" :data="sectionData || []" @projectCreated="fetchSectionData('projects')"></component>
        </div>
      </div>

      <ModalComponent :isOpen="isModalOpen" @close="closeModal">
      <template #header>
        <h3>{{ modalTitle }}</h3>
      </template>
      <template #body>
        <component :is="modalComponent" :user="user" @create-task="createTask" @create-project="createProject" />
      </template>
      <template #footer>
        <button @click="closeModal">Close</button>
      </template>
      </ModalComponent>

    </div>
</template>
  
  <script>
  import ProjectsComponent from './ProjectsComponent.vue';
  import TasksComponent from './TasksComponent.vue';
  import CreateTaskForm from './CreateTaskForm.vue';
  import ModalComponent from './ModalComponent.vue';
  import CreateProjectForm from './CreateProjectForm.vue';
  
  export default {
    data() {
      return {
        user: null,
        selectedSection: null,
        sectionData: [],
        isModalOpen: false,
        modalComponent: null,
        modalTitle: '',
      };
    },
    computed: {
      currentComponent() {
        switch (this.selectedSection) {
          case 'projects':
            return ProjectsComponent;
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
        this.selectSection('projects');
      } else {
        this.$router.push('/login');
      }
    },
    methods: {
      openModal(type) {
        this.isModalOpen = true;
        if (type === 'task') {
          this.modalComponent = CreateTaskForm;
          this.modalTitle = 'Create Task';
        } else if (type === 'project') {
          this.modalComponent = CreateProjectForm;
          this.modalTitle = 'Create Project';
        }
      },
      closeModal() {
        this.isModalOpen = false;
      },
      createTask(taskData) {
        fetch('http://127.0.0.1:8000/api/manager/tasks/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(taskData),
          credentials: 'include',
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to create task');
          }
          return response.json();
        })
        .then(() => {
          this.fetchSectionData('tasks');
          this.closeModal();
        })
        .catch(error => console.error('Error creating task:', error));
      },
      createProject(projectData) {
        fetch('http://127.0.0.1:8000/api/manager/projects/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(projectData),
          credentials: 'include',
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to create project');
          }
          return response.json();
        })
        .then(() => {
          this.fetchSectionData('projects');
          this.closeModal();
        })
        .catch(error => console.error('Error creating project:', error));
      },
      selectSection(section) {
        this.selectedSection = section;
        this.fetchSectionData(section);
      },
      fetchSectionData(section) {
        let url = '';
        const userId = this.user.id; // Получаем user_id из локального хранилища
        switch (section) {
          case 'projects':
            url = `http://127.0.0.1:8000/api/manager/projects`; // URL для получения проектов
            break;
          case 'tasks':
            url = `http://127.0.0.1:8000/api/user/tasks`; // URL для получения задач
            break;
        }
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ user_id: userId }),
          credentials: 'include',
        })
        .then(response => response.json())
        .then(data => {
          this.sectionData = data;
        })
        .catch(error => console.error('Error fetching data:', error));
      },
    },
    components: {
      ProjectsComponent,
      TasksComponent,
      CreateTaskForm,
      ModalComponent,
      CreateProjectForm
    },
  };
  </script>
  
  <style scoped>
  .header {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background-color: #f8f9fa;
  }

  .main-page {
    padding: 20px;
  }

  .content {
    padding: 20px;
  }
  .role-actions {
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid black;
    gap: 90px;
  }

  .role-actions button {
    width: 150px;
    height: 50px;
    background-color: #fff;
    border: none;
    font-size: 20px;
  }
  .info-box {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
  }

  .kanit-bold {
    font-family: "Kanit", serif;
    font-weight: 700;
    font-style: normal;
  }
  </style>
  