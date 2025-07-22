<?php $__env->startSection('extra-css'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .achieved {
            background-color: gold !important;
            color: #28282B !important; 
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-3 p-5">
                <img src="<?php echo e($user->profile->profileImage()); ?>" class="rounded-circle w-100">
            </div>
            <div class="col-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center pb-3">
                        <div class="h4"><?php echo e($user->username); ?></div>
                        <?php if($user->id != Auth::user()->id): ?>
                            <follow-button user-id="<?php echo e($user->id); ?>" follows="<?php echo e($follows); ?>"></follow-button>
                        <?php endif; ?>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profile)): ?>
                        <a href="/p/create">Add New Post</a>
                    <?php endif; ?>

                </div>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profile)): ?>
                    <a href="/profile/<?php echo e($user->id); ?>/edit">Edit Profile</a>
                <?php endif; ?>

                <div class="d-flex">
                    <div class="pr-5"><strong><?php echo e($postCount); ?></strong> posts</div>
                    <div class="pr-5"><strong><?php echo e($followersCount); ?></strong> followers</div>
                    <div class="pr-5"><strong><?php echo e($followingCount); ?></strong> following</div>
                </div>
                <div class="pt-4 font-weight-bold"><?php echo e($user->profile->title); ?></div>
                <div><?php echo e($user->profile->description); ?></div>
                <div><a href="#"><?php echo e($user->profile->url); ?></a></div>
            </div>
        </div>
        <div>

            <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#collapseAchievements"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="bi bi-controller mr-2"></i> Achievements
            </button>
        </div>
        <div class="collapse card card-body" id="collapseAchievements">
            <div class="row">
                <?php $__currentLoopData = $userAchievement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $UA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $achieved=!is_null($UA->unlocked_at);
                ?>
                    <div class="col-4">
                        <div class="card <?php echo e($achieved ?  'achieved':'bg-light'); ?>">
                            <div class="card-body d-flex align-items-center">
                                <div class="p-4">
                                    <img class='<?php echo e(!$achieved ? 'text-secondary' : ''); ?>' style='width:50px; height:auto; <?php echo e(!$achieved ? 'filter: contrast(25%)' : ''); ?>' src="<?php echo e(asset($UA->achievement->icon)); ?>" alt="">
                                </div>
                                <div>
                                    <div class="p-1 <?php echo e(!$achieved ? 'text-secondary' : ''); ?>font-weight-bold"><?php echo e($UA->achievement->name); ?></div>
                                    <div class="p-1 <?php echo e(!$achieved ? 'text-secondary' : ''); ?>small"><?php echo e($UA->achievement->description); ?></div>
                                    <div class="p-1 <?php echo e(!$achieved ? 'text-secondary' : ''); ?>h5"><?php echo e($UA->progress_total); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="row pt-3">
            <?php $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 pb-4">
                    <a href="/p/<?php echo e($post->id); ?>">
                        <img src="/storage/<?php echo e($post->image); ?>" class="w-100">
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gamer_streetv2\resources\views/profiles/index.blade.php ENDPATH**/ ?>