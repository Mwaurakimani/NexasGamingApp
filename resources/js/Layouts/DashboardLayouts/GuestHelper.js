
const guest_navigation_button = [
    {
        name: "Dashboard",
        link: [
            route("dashboard")
        ]
    },
    {
        name: "Matches",
        link: [
            route('matches.list'),
            route('matches.view_match',[1])
        ]
    },
    {
        name: "Profile",
        link: [
            route('profile.view')
        ]
    },
    {
        name: "Transactions",
        link: [
            route('transactions.list')
        ]
    }
]


const super_admin_links = [
    {
        name: "Dashboard",
        link: [
            route("dashboard")
        ]
    },
    {
        name: "Matches",
        link: [
            route('matches.list'),
            route('matches.view_match',[1])
        ]
    },
    {
        name: "Profile",
        link: [
            route('profile.view')
        ]
    },
    {
        name: "Transactions",
        link: [
            route('transactions.list')
        ]
    },
    {
        name: "Accounts",
        link: [
            route('accounts.list'),
            route('accounts.view_user',[1])
        ]
    },
]

function add_links(user){
    if(user.role_name === "Super Admin"){
        return super_admin_links
    }
    return guest_navigation_button
}

const openMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '100%'})
}
const closeMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '0%'})
}


export {
    openMenu, closeMenu,add_links
}
