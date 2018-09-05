import {RouterModule, Routes} from "@angular/router";
// import {SplashComponent} from "./splash/splash.component";
// import {UserService} from "./shared/services/user.service";
import {APP_BASE_HREF} from "@angular/common";
import {HomeComponent} from "./home/home.components";


export const allAppComponents = [HomeComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
];

export const routing = RouterModule.forRoot(routes);