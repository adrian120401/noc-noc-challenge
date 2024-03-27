import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/'
})

const token = localStorage.getItem('token')

export const login = async (email, password) => {
  const response = await axiosInstance.post('auth/login', {
    email: email,
    password: password
  })
  return response.data
}

export const addTask = async (task) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.post('tasks', { ...task }, config)
  return response.data
}

export const getTasks = async () => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.get('tasks', config)
  return response.data
}

export const updateStatus = async (id, status) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.patch(`tasks/${id}/status`, { status: status }, config)
  return response.data
}

export const updateUser = async (id, user_id) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.patch(`tasks/${id}/user`, { assigned_to: user_id }, config)
  return response.data
}

export const deleteTask = async (id) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.delete(`tasks/${id}`, config)
  return response.data
}

export const getComments = async (id) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.get(`task/${id}/comments`, config)
  return response.data
}

export const createComment = async (id, comment) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.post(`task/${id}/comments`, { comment: comment }, config)
  return response.data
}

export const getUsers = async () => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.get('users', config)
  return response.data
}

export const uploadFile = async (formData, id) => {
  const config = {
    headers: {
      Authorization: `Bearer ${token}`,
      'Content-Type': 'multipart/form-data'
    }
  }
  const response = await axiosInstance.post(`task/${id}/file`, formData, config)
  return response.data
}

export const getFiles = async (id) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.get(`task/${id}/file`, config)
  return response.data
}

export const deleteFile = async (id) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.delete(`file/${id}`, config)
  return response.data
}

export const getReport = async (dateStart, dateEnd) => {
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  }
  const response = await axiosInstance.get(
    `tasks/report?date_start=${dateStart}&date_end=${dateEnd}`,
    config
  )
  return response.data
}

export const setPassword = async (token, password) => {
  const response = await axiosInstance.post('auth/password', { password: password, remember_token: token})
  return response.data
}

export const forgotPassword = async (email) => {
  const response = await axiosInstance.post('auth/forgot', { email: email })
  return response.data
}

export default axiosInstance
