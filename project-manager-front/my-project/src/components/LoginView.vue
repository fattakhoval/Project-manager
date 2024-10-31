<template>
    <div class="login-container">
      <div class="header heading">
        <h1 class="kanit-bold">Welcome to HardWork!</h1>
        <img src="../assets/logomin.png" alt="Icon" class="icon" />
      </div>

      <div class="container">
        <div class="form kanit-bold">
          <form @submit.prevent="handleSubmit" id="signin_form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" v-model="email" required />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" v-model="password" required />
            </div>
            <button type="submit" class="kanit-bold">Sign In</button>
          </form>

         

        </div>

        <div class="img_men">
          <img src="../assets/men.png" alt="Person with laptop" />
        </div>
      </div>
     
      
      
     
    </div>
      <div class="footer">
    <!-- <p>Don't have an account? Send your Admin</p> -->

        <p>SINCE 2021</p>
      </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      handleSubmit() {
        // Отправка данных на сервер
        fetch('http://127.0.0.1:8000/api/auth/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            console.log(data)
            localStorage.setItem('user', JSON.stringify(data.user));
            this.$router.push('/');
          } else {
            alert('Login failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* .login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 20px;

     display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
  } */

  *{
    margin: 0;
    padding: 0;
}

/* header {
    width: 100%;
    height: 100px;
    background-color: #fff;
    display: flex;
    justify-content: center;
    gap: 80%;
    align-items: center;
} */


.login-container {
  padding-top: 30px;

}

.heading {
    display: flex;
    justify-content: center;
    gap: 10px;
    align-items: center;
    padding: 20px 0 20px 0;
    
}

.kanit-bold {
    font-family: "Kanit", serif;
    font-weight: 700;
    font-style: normal;
  }

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    padding: 20px 0 20px 0;
}

.form {
    width: 500px;
    height: 300px;
    border: 2px solid black;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

#signin_form input{
    width: 400px;
    height: 40px;
    background-color: #4a4849;
    color: #fff;
    font-family: "Kanit", serif;
    font-weight: 700;
    font-style: normal;
    padding-left: 10px;
}

#signin_form{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 40px;
}

#signin_form .form-group{
    display: flex;
    flex-direction: column;
}

#signin_form button {
    width: 100px;
    height: 40px;
    background-color: black;
    color: #fff;
    border:  none;
}

.img_men img{
    width: 450px;
}

.footer {
  width: 100%;
  padding: 20px 0 20px 0;
 
  display: flex;
  justify-content: center;
  align-items: center;
}
  
  /* .header {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .logo, .icon {
    width: 50px;
    height: 50px;
    margin: 0 10px;
  }
  
  .form-group {
    margin: 10px 0;
  }
  
  input {
    width: 200px;
    padding: 10px;
    margin-top: 5px;
  }
  
  button {
    padding: 10px 20px;
    margin-top: 10px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  
  
  .image-placeholder {
    margin-top: 20px;
  }
  
  .image-placeholder img {
    width: 150px;
    height: auto;
  } */
  </style>
  