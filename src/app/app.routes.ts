import {RouterModule, Routes} from "@angular/router";
// import {SplashComponent} from "./splash/splash.component";
// import {UserService} from "./shared/services/user.service";
import {APP_BASE_HREF} from "@angular/common";

/*Service Imports*/
import {ActivityService} from "./shared/services/activity.service";
import {RecAreaService} from "./shared/services/rec.area.service";
import {ReviewService} from "./shared/services/review.service";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignUpService} from "./shared/services/sign.up.service";
import {ActivationService} from "./shared/services/activation.service";
import {AuthService} from "./shared/services/auth.service";
import {ProfileService} from "./shared/services/profile.service";

/*Interceptor Imports*/
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";

/*Component Imports*/
import {HomeComponent} from "./home/home.component";
import {ExploreComponent} from "./explore/explore.component";
import {RecAreaModalComponent} from "./explore/recArea-modal/recArea-modal.component";
import {ProfileComponent} from "./profile/profile.component";
import {RecAreaListComponent} from "./explore/recArea-list/recArea-list.component";
import {SignInComponent} from "./shared/components/sign-in/sign-in.component";
import {SignUpComponent} from "./shared/components/sign-up/sign-up.component";
import {ReviewPostComponent} from "./reviewpost/review-post.component";
import {MainNavComponent} from "./shared/components/main-nav/main-nav.component";
import {AboutComponent} from "./about/about.component";
import {AreaComponent} from "./area/area.component";



export const allAppComponents = [HomeComponent, AboutComponent, AreaComponent, ExploreComponent, MainNavComponent, RecAreaModalComponent, ProfileComponent, RecAreaListComponent, SignInComponent, SignUpComponent, ReviewPostComponent];

export const routes: Routes = [
	{path: "about", component: AboutComponent},
	{path: "review-post", component: ReviewPostComponent},
	{path: "area/:recAreaId", component: AreaComponent},
	{path: "recArea", component: RecAreaListComponent},
	{path: "explore", component: ExploreComponent},
	{path: "sign-up-modal", component: SignUpComponent},
	{path: "sign-in", component: SignInComponent},
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent}
];
const services : any[] = [ActivationService, ActivityService, AuthService, ProfileService, RecAreaService, ReviewService, SessionService, SignInService, SignUpService];
const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];
export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);