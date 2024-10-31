<template>
    <header class="header kanit-bold">
      <img src="../assets/logo.png" alt="Logo_1" class="logo" />
      
      <button @click="logout" class="kanit-bold">Exit</button>
    </header>
</template>

<script>
export default {

  data() {
    return {
      role: 'Админ',
      selectedSection: null,
    };
  },
  name: 'HeaderComponent',
  methods: {
    selectSection(section) {
      this.selectedSection = section;
    },
    logout() {
      fetch('http://127.0.0.1:8000/api/auth/logout', {
        method: 'POST',
        credentials: 'include', // Если используешь куки
      })
      .then(response => {
        if (response.ok) {
          localStorage.removeItem('user');
          this.$router.push('/login');
        } else {
          console.error('Logout failed');
        }
      })
      .catch(error => console.error('Error:', error));
    },
  }
  };
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,700;1,900&display=swap');

*{
  padding: 0;
  margin: 0;
}

.kanit-bold {
    font-family: "Kanit", serif;
    font-weight: 700;
    font-style: normal;
  }

.header {
  width: 100%;

  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header button {
  width: 110px;
  height: 40px;
  background-color: black;
  border:  none;
  color: #fff;
}
</style>