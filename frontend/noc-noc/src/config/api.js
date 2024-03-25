import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/',
});

export const login = async (email, password) => {
      const response = await axiosInstance.post('login', {
        email: email,
        password: password
      });
      return response.data;
};

export const getTasks = async ( token ) => {
      const config = {
        headers: { Authorization: `Bearer ${token}` }
      };
      const response = await axiosInstance.get('tasks' , config);
      return response.data;
}
export default axiosInstance;