
import moment from 'moment'
const MyHelpers = {
    data() {
        return {
        }
    },
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
        
    },
    computed: {
        layouts() {
            let header = 'Branches'
            switch (this.route().current()) {
                case 'branches.index':
                    header = 'Branches'
                    break;
                case 'branch.transactions.index':
                    header = this.$page.props.branch.name
                    break;
                case 'wallets.index':
                    header = 'Wallets'
                    break;
                case 'wallet.transactions.index':
                    header = this.$page.props.wallet.name
                    break;
                case 'customers.index':
                    header = 'Customers'
                    break;
                case 'users.index':
                    header = 'Users'
                    break;
                default:
                    header = ''
                    break;
            }
            return {
                header: header
            }
        }
    }
}

export default MyHelpers;