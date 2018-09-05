import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs/internal/Observable";
import {Status} from "../interfaces/status";


@Injectable()
export class SignInService {
	constructor(protected http : HttpClient) {

	}

	private signInUrl = "api/sign-in/";
	private signOutUrl = "api/sign-out";

	//perform the post to initiate sign in
	postSignIn(signIn:SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.signInUrl, signIn));
	}

	signOut() : Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl))
	}
}