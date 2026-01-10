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

export default {
    computed: {
        chartColors() {
            return [
                '#3B82F6', // Blue
                '#EAB308', // Yellow

                '#EF476F', // Soft red
                '#A855F7', // Violet
                '#06B6D4', // Cyan
                '#22C55E', // Green

                '#F59E0B', // Amber
                '#6366F1', // Indigo

                '#94A3B8', // Slate (neutral)
                '#64748B', // Dark slate (for “Other”)
            ]
        }
    }
}
