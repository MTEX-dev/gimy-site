<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteDeployment;
use Illuminate\Http\Request;

class SiteDeploymentController extends Controller
{
    public function create(Site $site)
    {
        return view('sites.deployments.create', compact('site'));
    }

    public function store(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        // In a real application, this would be a more complex process
        // involving a build process, but for now, we'll just create a
        // new deployment record.

        $deployment = $site->siteDeployments()->create([
            'status' => 'pending',
        ]);

        // Here you would trigger a job to perform the deployment

        return redirect()->route('sites.show', $site);
    }
}
