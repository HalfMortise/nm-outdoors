import {RouterModule, Routes} from "@angular/router";
// import {SplashComponent} from "./splash/splash.component";
// import {UserService} from "./shared/services/user.service";
import {APP_BASE_HREF} from "@angular/common";
import {HomeComponent} from "./home/home.components";
import {ActivityService} from "./shared/services/activity.service";
import {RecAreaService} from "./shared/services/rec.area.service";
import {ReviewService} from "./shared/services/review.service";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignUpService} from "./shared/services/sign.up.service";
import {ActivationService} from "./shared/services/activation.service";
import {AuthService} from "./shared/services/auth.service";
import {ProfileService} from "./shared/services/profile.service";


export const allAppComponents = [HomeComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];
const services : any[] = [ActivationService, ActivityService, AuthService, ProfileService, RecAreaService, ReviewService, SessionService, SignInService, SignUpService];
const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
];
export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);