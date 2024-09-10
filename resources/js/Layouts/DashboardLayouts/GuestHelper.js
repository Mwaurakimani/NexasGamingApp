const navigation_button = [
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

const openMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '100%'})
}
const closeMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '0%'})
}

export {
    navigation_button,
    openMenu, closeMenu
}
