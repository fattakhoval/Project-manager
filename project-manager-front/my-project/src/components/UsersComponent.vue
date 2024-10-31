<template>
    <div class="users">
      <button @click="openCreateModal">Добавить пользователя</button>
      <ul>
        <li v-for="user in data" :key="user.id" class="user-item">
          <h3>{{ user.name }}</h3>
          <p><strong>Email:</strong> {{ user.email }}</p>
          <p><strong>Role:</strong> {{ user.role }}</p>
          <button @click="openEditModal(user)">Edit</button>
          <button @click="confirmDeleteUser(user.id)">Delete</button>
        </li>
      </ul>
  
      <ModalComponent :isOpen="isModalOpen" @close="isModalOpen = false">
        <template #header>
          <h2>{{ isEditMode ? 'Edit User' : 'Create User' }}</h2>
        </template>
        <template #body>
          <input v-model="editedUser.name" placeholder="User Name" />
          <input v-model="editedUser.email" placeholder="User Email" />
          <input v-if="!isEditMode" v-model="editedUser.password" placeholder="User Password" type="password" />
          <select v-model="editedUser.role">
            <option>Админ</option>
            <option>Руководитель проекта</option>
            <option>Исполнитель</option>
          </select>
          <div v-if="serverResponse">
            <p><strong>Пароль пользователя:</strong> {{ serverResponse.notHisPassword }}</p>
          </div>
        </template>
        <template #footer>
          <button @click="isEditMode ? saveUser() : createUser()">Save</button>
          <button @click="isModalOpen = false">Cancel</button>
        </template>
      </ModalComponent>
    </div>
  </template>
  
  <script>
    import ModalComponent from './ModalComponent.vue';
  export default {
    components: {
      ModalComponent,
    },
    props: {
        data: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        isModalOpen: false,
        isEditMode: false,
        editedUser: {},
        serverResponse: null,
      };
    },
    methods: {
      openCreateModal() {
        this.isEditMode = false;
        this.editedUser = { name: '', email: '', password: '', role: 'Исполнитель' };
        this.isModalOpen = true;
        this.serverResponse = null;
      },
      createUser() {
        fetch('http://127.0.0.1:8000/api/admin/users', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(this.editedUser),
        })
        .then(response => response.json())
        .then(data => {
            this.serverResponse = data;
            this.$emit('userCreated', data.user);
            // this.isModalOpen = false;
        })
        .catch(error => console.error('Error creating user:', error));
      },
      formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString(undefined, options);
      },
      openEditModal(user) {
      this.isEditMode = true;
      this.editedUser = { ...user };
      this.isModalOpen = true;
    },
      saveUser() {
  console.log('Saving user:', this.editedUser);

  fetch(`http://127.0.0.1:8000/api/admin/users/${this.editedUser.id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(this.editedUser),
  })
  .then(response => {
    if (response.ok) {
      console.log('User updated successfully');
      this.isModalOpen = false; // Закрываем модальное окно
      this.$emit('userUpdated', this.editedUser); // Эмитируем событие для обновления списка
    } else {
      console.error('Failed to update user');
    }
  })
  .catch(error => {
    console.error('Error updating user:', error);
  });
},
      confirmDeleteUser(userId) {
        if (confirm('Мис клик или действительно удаляем его? Может простим, пусть живет себе.')) {
            this.deleteUser(userId);
        }
      },
      deleteUser(userId) {
        fetch(`http://127.0.0.1:8000/api/admin/users/${userId}`, {
        method: 'DELETE',
      })
      .then(response => {
        if (response.ok) {
          console.log('User deleted successfully');
          this.$emit('userDeleted', userId); // Эмитируем событие для обновления списка
        } else {
          console.error('Failed to delete user');
        }
      })
      .catch(error => {
        console.error('Error deleting user:', error);
      });
      },
    },
  };
  </script>
  
  <style scoped>
  .users {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
  }
  
  .user-item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
  }
  </style>
  