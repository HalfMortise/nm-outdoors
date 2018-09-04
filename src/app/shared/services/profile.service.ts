import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
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
	return(this.http.get<Profile>(this.profileUrl, {params: new HttpParams().set("id", profileId)}));
}

//call to the Profile API and get profile object by profile email
	getProfileByProfileEmail(profileEmail: string) : Observable<Profile>{
		return(this.http.get<Profile>(this.profileUrl, {params: new HttpParams().set("email", profileEmail )}));
	}

	//call to the Profile API and create a new profile
	createProfile(profile: Profile) : Observable<Status>{
		return(this.http.post<Status>(this.profileUrl, profile));
	}

	//call to the Profile API and edit the profile
	editProfile(profile: Profile) : Observable<Status>{
		return(this.http.put<Status>(this.profileUrl + profile.profileId, profile));
	}

}