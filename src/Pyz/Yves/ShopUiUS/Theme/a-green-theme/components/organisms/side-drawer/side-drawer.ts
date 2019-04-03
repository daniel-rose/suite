import SprykerSideDrawer from 'ShopUi/components/organisms/side-drawer/side-drawer';

export default class SideDrawer extends SprykerSideDrawer {
    toggle(): void {
        super.toggle();
        console.log('Toggling side drawer...');
    }
}
