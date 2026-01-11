/*
 * Copyright (c) 2026 ISAPP (isapp.be)
 * All rights reserved.
 *
 * This source code is proprietary and confidential.
 * No part of this software may be reproduced, distributed, or transmitted in any form or by any means without prior written permission from ISAPP.
 *
 * License: Commercial. See LICENSE.md.
 */

import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Colors,
    Legend,
    LinearScale,
    LineElement,
    PointElement,
    Title,
    Tooltip
} from 'chart.js'
import {Line, Pie} from "vue-chartjs";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,
    CategoryScale,
    LinearScale,
    PointElement,
    ArcElement,
    LineElement,
    Title,
    Tooltip,
    Colors,
    Legend
)

export function useChart() {
    return {
        LineChart: Line,
        PieChart: Pie
    }
}
