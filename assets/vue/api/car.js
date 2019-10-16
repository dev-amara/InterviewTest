import axios from 'axios';

export default {
    getAll() {
        return axios.get('/api/v1/cars');
    },

    get($id) {
        return axios.get('/api/v1/cars/'+$id );
    },

    post() {
        return axios.post('/api/v1/cars', data, {
                headers: {
                    'Content-Type': 'application/json',
                }
            }
        );
    }
}