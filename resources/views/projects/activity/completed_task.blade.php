{{ $activity->user->id === auth()->user()->id ? 'You' :  $activity->user->name }} completed "{{ $activity->subject->body}}" task.