import {Injectable} from "@angular/core";
import {Profile} from "../interfaces/profile";
import {Observable} from "rxjs";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable()

export class ProfileService {
	constructor(protected http: HttpClient) {}
	//api endpoint
	private profileUrl = "api/Profile/";

	//call to the Profile API and get profile object by its id
getProfileByProfileId(profileId: string) : Observable<Profile>{
	return(this.http.get<Profile>(this.profileUrl, {params: new HttpParams().set("id", profileId)}))
}

}