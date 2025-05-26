<?php
// run periodically to update user progress
require_once("settings.php");

function updateUserProgress($user_id, $conn) {
    // check if required columns exist
    $columns_check = mysqli_query($conn, "SHOW COLUMNS FROM consciousness_uploads LIKE 'UploadProgress'");
    if (mysqli_num_rows($columns_check) == 0) {
        return; // skip if columns don't exist yet
    }
    
    // get current user data
    $stmt = mysqli_prepare($conn, "SELECT UploadProgress, NeuralPathwaysTotal, NeuralPathwaysMapped, MemoryFragmentsTotal, MemoryFragmentsMapped, Status, LastProgressUpdate FROM consciousness_uploads WHERE UploadID = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if (!$user || $user['Status'] == 'Uploaded' || !$user['UploadProgress']) {
        return; // don't update if already uploaded or no progress data
    }
    
    // calculate time since last update
    $last_update = new DateTime($user['LastProgressUpdate'] ?? 'now');
    $now = new DateTime();
    $hours_passed = $now->diff($last_update)->h + ($now->diff($last_update)->days * 24);
    
    if ($hours_passed >= 1) { // update every hour
        // gradually increase progress
        $progress_increase = rand(1, 5);
        $new_progress = min(100, $user['UploadProgress'] + $progress_increase);
        
        // update neural pathways and memory fragments
        if ($user['NeuralPathwaysTotal'] > 0) {
            $neural_increase = ($progress_increase / 100) * $user['NeuralPathwaysTotal'];
            $memory_increase = ($progress_increase / 100) * $user['MemoryFragmentsTotal'];
            
            $new_neural = min($user['NeuralPathwaysTotal'], $user['NeuralPathwaysMapped'] + $neural_increase);
            $new_memory = min($user['MemoryFragmentsTotal'], $user['MemoryFragmentsMapped'] + $memory_increase);
        } else {
            $new_neural = $user['NeuralPathwaysMapped'];
            $new_memory = $user['MemoryFragmentsMapped'];
        }
        
        // update status if progress reaches 100%
        $new_status = $user['Status'];
        if ($new_progress >= 100) {
            $new_status = 'Uploaded';
        }
        
        // update database
        $update_stmt = mysqli_prepare($conn, "UPDATE consciousness_uploads SET UploadProgress = ?, NeuralPathwaysMapped = ?, MemoryFragmentsMapped = ?, Status = ?, LastProgressUpdate = CURRENT_TIMESTAMP WHERE UploadID = ?");
        mysqli_stmt_bind_param($update_stmt, "iiisi", $new_progress, $new_neural, $new_memory, $new_status, $user_id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
        
        // add activity log
        $activities = [
            'Neural pathway optimization completed',
            'Memory fragment consolidation in progress',
            'Consciousness integrity maintained',
            'Digital stability enhanced',
            'Server synchronization completed',
            'Backup protocols executed',
            'Security scan completed'
        ];
        
        $activity = $activities[array_rand($activities)];
        $activity_stmt = mysqli_prepare($conn, "INSERT INTO user_activity_log (UserID, ActivityType, ActivityDescription, ImportanceLevel) VALUES (?, 'System', ?, 'Low')");
        mysqli_stmt_bind_param($activity_stmt, "is", $user_id, $activity);
        mysqli_stmt_execute($activity_stmt);
        mysqli_stmt_close($activity_stmt);
        
        // check for achievements
        if ($new_progress >= 50 && $user['UploadProgress'] < 50) {
            $achievement_stmt = mysqli_prepare($conn, "INSERT INTO user_achievements (UserID, AchievementName, AchievementDescription, AchievementIcon, PointsAwarded) VALUES (?, 'Half-Digital', 'Reached 50% consciousness upload', '🌓', 25)");
            mysqli_stmt_bind_param($achievement_stmt, "i", $user_id);
            mysqli_stmt_execute($achievement_stmt);
            mysqli_stmt_close($achievement_stmt);
        }
        
        if ($new_status == 'Uploaded' && $user['Status'] != 'Uploaded') {
            $achievement_stmt = mysqli_prepare($conn, "INSERT INTO user_achievements (UserID, AchievementName, AchievementDescription, AchievementIcon, PointsAwarded) VALUES (?, 'Digital Immortal', 'Successfully completed consciousness upload', '👑', 100)");
            mysqli_stmt_bind_param($achievement_stmt, "i", $user_id);
            mysqli_stmt_execute($achievement_stmt);
            mysqli_stmt_close($achievement_stmt);
        }
    }
}
?>