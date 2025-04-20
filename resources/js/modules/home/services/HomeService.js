// modules/home/services/HomeService.js
import AppService from '@/core/AppService'

export default class HomeService extends AppService {
    constructor() {
        super('home')
    }

    async getStats() {
        return await this.request('stats')
    }
}
