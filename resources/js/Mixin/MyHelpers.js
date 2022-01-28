
import moment from 'moment'
const MyHelpers = {
    created() {
        this.moment = moment;
    },
    methods: {
        assign(data) {
            return JSON.parse(JSON.stringify(data));
        },
        money(amount) {
            // Create our number formatter.
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
            });
            
            return formatter.format(amount);
        }
    },
    components: {
        
    }
}

export default MyHelpers;