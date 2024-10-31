import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/LoginView.vue';
import MainVue from '@/components/MainVue.vue';
import ProjectTasks from '../components/ProjectTasks.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/', component: MainVue },
  {
    path: '/projects/:projectId/tasks',
    name: 'project-tasks',
    component: ProjectTasks,
    props: (route) => ({ projectId: route.params.projectId, projectName: route.query.projectName }),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
